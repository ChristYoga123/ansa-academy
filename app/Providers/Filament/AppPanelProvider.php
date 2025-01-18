<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\LombaResource;
use App\Filament\Resources\MenteeResource;
use App\Filament\Resources\MentorResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\ArtikelResource;
use App\Filament\Resources\LokerMentorResource;
use App\Filament\Resources\ProgramJasaResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Resources\ProdukDigitalResource;
use Filament\Http\Middleware\AuthenticateSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use FilipFonal\FilamentLogManager\FilamentLogManager;
use GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->login()
            ->colors([
                'primary' => '#28C4D3',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->shouldRegisterNavigation(false)
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars', // image will be stored in 'storage/app/public/avatars
                        rules: 'mimes:jpeg,png,jpg|max:1024' //only accept jpeg and png files with a maximum size of 1MB
                    )
                    ->canAccess(fn() => auth()->user()->can('page_EditProfilePage')),
                FilamentLogManager::make(),
                FilamentEnvEditorPlugin::make()
                    ->hideKeys('APP_KEY', 'BCRYPT_ROUNDS')
                    ->authorize(
                        // fn () => auth()->user()->isAdmin()
                    ),
                FilamentShieldPlugin::make(),
            ])
            // topbar
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => "Edit Profile")
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-cog-6-tooth')
                    ->visible(function (): bool {
                        return auth()->user()->can('page_EditProfilePage');
                    }),
            ])
            // sidebar
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('')
                        ->items([
                            ...Dashboard::getNavigationItems(),
                            ...ArtikelResource::getNavigationItems(),
                            ...LombaResource::getNavigationItems(),
                            ...ProdukDigitalResource::getNavigationItems(),
                            ...EventResource::getNavigationItems(),
                            // ...ArtikelResource::getNavigationItems(),
                            // ...ProdukDigitalResource::getNavigationItems(),
                            // ...LombaResource::getNavigationItems(),
                            // ...EventResource::getNavigationItems(),
                            // ...MentoringResource::getNavigationItems(),
                            // ...TransaksiResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Karir')
                        ->items([
                            ...LokerMentorResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Master Data')
                        ->items([
                            ...MenteeResource::getNavigationItems(),
                            ...MentorResource::getNavigationItems(),
                            ...ProgramJasaResource::getNavigationItems(),
                            // ...MentorResource::getNavigationItems(),
                            // ...MenteeResource::getNavigationItems(),
                            // ...KategoriMentoringResource::getNavigationItems(),
                            // ...FAQResource::getNavigationItems(),
                            // ...IklanResource::getNavigationItems(),
                            // ...PageResource::getNavigationItems(),
                            // ...CategoryResource::getNavigationItems(),
                            // ...HomePageSettings::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Settings')
                        ->items([
                            NavigationItem::make('Roles & Permissions')
                                ->icon('heroicon-s-shield-check')
                                ->visible(fn() => auth()->user()->can('view_role') && auth()->user()->can('view_any_role'))
                                ->url(fn() => route('filament.app.resources.shield.roles.index'))
                                ->isActiveWhen(fn() => request()->routeIs('filament.app.resources.shield.roles.*')),
                            NavigationItem::make('Environment Editor')
                                ->icon('heroicon-s-cog')
                                ->url(fn() => route('filament.app.pages.env-editor'))
                                ->visible(fn() => auth()->user()->can('page_ViewEnv'))
                                ->isActiveWhen(fn() => request()->routeIs('filament.app.pages.env-editor')),
                            NavigationItem::make('Logs')
                                ->icon('heroicon-s-newspaper')
                                ->url(fn() => route('filament.app.pages.logs'))
                                ->visible(fn() => auth()->user()->can('page_Logs'))
                                ->isActiveWhen(fn() => request()->routeIs('filament.app.pages.logs')),
                        ]),

                ]);
            })
            ->spa();
    }
}
