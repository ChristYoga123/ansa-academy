<?php 

use App\Models\Transaksi;
use App\Models\KelasAnsaMentee;
use App\Models\MentoringMentee;
use App\Models\ProofreadingMentee;
use Illuminate\Support\Facades\Log;
function deleteUnpaidTransaction($transaksiType)
{
    try {
        $transaksi = Transaksi::where('transaksiable_type', $transaksiType)
            ->whereMenteeId(auth()->id())
            ->where('status', '!=', 'Sukses')
            ->first();
        if($transaksi) {
            if($transaksi->transaksiable_type === MentoringMentee::class) {
                MentoringMentee::find($transaksi->transaksiable_id)->delete();
            }elseif($transaksi->transaksi_type === KelasAnsaMentee::class) {
                KelasAnsaMentee::find($transaksi->transaksiable_id)->delete();
            }elseif($transaksi->transaksi_type === ProofreadingMentee::class) {
                ProofreadingMentee::find($transaksi->transaksiable_id)->delete();
            }
            $transaksi->delete();
        }
    } catch (Exception $e) {
        Log::error('Delete unpaid transaction error: ' . $e->getMessage());
        throw new Exception('Delete unpaid transaction error ' . $e->getMessage());
    }
}
?>