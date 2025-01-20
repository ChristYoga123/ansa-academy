<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Contracts\PaymentServiceInterface;

class EventController extends Controller
{
    public function __construct(
        protected PaymentServiceInterface $paymentService
    ) {}
    
    public $title = 'Event';

    public function index(Request $request)
    {
        $query = Event::query()->latest('waktu_pelaksanaan');
        $now = Carbon::now();

        // Apply search filter if provided
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('judul', 'like', "%{$searchTerm}%");
        }

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'open') {
                $query->where('waktu_close_registrasi', '>', $now);
            } else {
                $query->where('waktu_close_registrasi', '<=', $now);
            }
        }

        // Get events with pagination
        $events = $query->latest()
                       ->paginate(9)
                       ->withQueryString();

        // Calculate status counts
        $statusCounts = [
            'total' => Event::count(),
            'open' => Event::where('waktu_close_registrasi', '>', $now)->count(),
            'closed' => Event::where('waktu_close_registrasi', '<=', $now)->count(),
        ];

        // Handle AJAX requests for filtering
        if ($request->ajax()) {
            $view = view('pages.event.index', [
                'events' => $events,
                'statusCounts' => $statusCounts,
                'title' => $this->title,
            ])->render();
            return response()->json(['html' => $view]);
        }

        return view('pages.event.index', [
            'events' => $events,
            'statusCounts' => $statusCounts,
            'title' => $this->title,
        ]);
    }

    public function show($slug)
    {
        $event = Event::with(['media'])->withCount('transaksis')->where('slug', $slug)->firstOrFail();
        $now = Carbon::now();
        $status = [
            'is_open' => $now->between($event->waktu_open_registrasi, $event->waktu_close_registrasi),
            'is_upcoming' => $now->lt($event->waktu_pelaksanaan),
            'registration_status' => $this->getRegistrationStatus($event, $now)
        ];

        return view('pages.event.show', [
            'event' => $event,
            'status' => $status,
            'title' => $this->title,
        ]);
    }

    public function enrollEvent($slug)
    {

        deleteUnpaidTransaction(Event::class);

        $event = Event::where('slug', $slug)->firstOrFail();
        
        if($event->checkUserEnrolled()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah terdaftar pada event ini'
            ], 400);
        }

        $transaksi = Transaksi::create([
            'mentee_id' => auth()->id(),
            'order_id' => 'ANSA-' . Str::random(8),
            'transaksiable_id' => $event->id,
            'transaksiable_type' => Event::class,
            'total_harga' => $event->harga,
            'status' => $event->pricing === 'gratis' ? 'Sukses' : 'Menunggu',
        ]);

        $snapToken = null;
        if($event->pricing === 'berbayar') {
            $snapToken = $this->paymentService->processPayment($transaksi);
            return response()->json(['snap_token' => $snapToken]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Anda berhasil mendaftar event ini',
            'redirect' => route('pembayaran-sukses')
        ]);
    }

    private function getRegistrationStatus($event, $now) 
    {
        if ($now->lt($event->waktu_open_registrasi)) {
            return [
                'message' => 'Segera Hadir',
                'class' => 'bg-info text-white'
            ];
        }

        if ($now->between($event->waktu_open_registrasi, $event->waktu_close_registrasi)) {
            return [
                'message' => 'Pendafataran Dibuka',
                'class' => 'bg-success text-white'
            ];
        }

        return [
            'message' => 'Pendaftaran Ditutup',
            'class' => 'bg-danger text-white'
        ];
    }
}
