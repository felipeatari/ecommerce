<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncCategoryJop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public ?int $categoryId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $category = Category::find($this->categoryId);

        if (!$category) return;

        $payload = [
            'descricao' => $category->name,
        ];
    }
}
