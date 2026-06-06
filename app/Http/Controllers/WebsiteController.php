<?php

namespace App\Http\Controllers;

use App\Enums\ListingKind;
use App\Enums\ListingStatus;
use App\Models\Company;
use App\Models\HomeSection;
use App\Models\Listing;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class WebsiteController extends Controller
{
    public function home(): View
    {
        $sections = HomeSection::query()
            ->active()
            ->orderBy('sort_order')
            ->get()
            ->keyBy('key');

        return view('website.home', [
            'settings' => SiteSetting::current(),
            'sections' => $sections,
            'companies' => Company::query()->active()->orderBy('sort_order')->get(),
            'jobs' => $this->listings(ListingKind::Job)->take(3)->get(),
            'tenders' => $this->listings(ListingKind::Tender)->take(3)->get(),
        ]);
    }

    public function story(): View
    {
        return view('website.story', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function jobs(): View
    {
        return $this->listingIndex(ListingKind::Job);
    }

    public function tenders(): View
    {
        return $this->listingIndex(ListingKind::Tender);
    }

    public function showJob(Listing $listing): View
    {
        return $this->listingShow($listing, ListingKind::Job);
    }

    public function showTender(Listing $listing): View
    {
        return $this->listingShow($listing, ListingKind::Tender);
    }

    protected function listingIndex(ListingKind $kind): View
    {
        return view('website.listings.index', [
            'settings' => SiteSetting::current(),
            'kind' => $kind,
            'listings' => $this->listings($kind)->paginate(9),
        ]);
    }

    protected function listingShow(Listing $listing, ListingKind $kind): View
    {
        abort_unless($listing->kind === $kind && $listing->status === ListingStatus::Published, 404);

        return view('website.listings.show', [
            'settings' => SiteSetting::current(),
            'kind' => $kind,
            'listing' => $listing,
        ]);
    }

    protected function listings(ListingKind $kind): Builder
    {
        return Listing::query()
            ->published()
            ->kind($kind)
            ->latest('published_at')
            ->latest();
    }
}
