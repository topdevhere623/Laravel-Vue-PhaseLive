<?php

namespace App\Traits\Marketplace;

use Stripe\FileLink as StripeFileLink;
use Stripe\File as StripeFile;

trait Files
{
    public function allFiles()
    {
        return StripeFile::all(['purpose' => 'dispute_evidence'], $this->stripeOptions());
    }

    public function retrieveFile($id)
    {
        $files = StripeFileLink::all([], $this->stripeOptions());
        return StripeFileLink::create([
            'file' => $files->data[0]->file,
        ], $this->stripeOptions());

//        if ($fileLink) {
//            return StripeFileLink::retrieve($fileLink->id, $this->stripeOptions());
//        }
    }
}
