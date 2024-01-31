<?php

namespace App\Console\Commands;

use App\Models\Auction;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class AuctionCreatePreview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:create:preview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create preview for auction';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $auctionElements = Auction::whereNull('preview_image')->whereNotNull('images')->get();
        foreach ($auctionElements as $auctionElement) {
            $imgPath = $auctionElement->images;
            if (isset($imgPath) && !empty($imgPath)) {
                $img = \Image::make(public_path($imgPath[0]));
                $img->fit(320, 240);
                $newImagePath = 'images/uploads/' . rand() . '.jpeg';
                $newPath = 'public/' . $newImagePath;
                $auctionElement->preview_image = $newImagePath;
                $img->save($newPath);
                $auctionElement->save();
            }
        }
    }
}
