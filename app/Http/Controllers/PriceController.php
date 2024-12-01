<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\Http\JsonResponse;

class PriceController extends Controller
{
    /**
     * @var int
     */
    private $user_id;

    /**
     * PriceController constructor.
     */
    public function __construct()
    {
        $this->user_id = auth()->user()->id;
    }

    /**
     * Subscribe to announcment price changes.
     * 
     * @param PriceRequest $request
     * @return JsonResponse
     */
    public function subscribe(PriceRequest $request): JsonResponse
    {
        $price = Price::firstOrCreate([
            'link' => $request->link,
            'type' => $this->getType($request->link), 
        ]);
        $price->users()->attach($this->user_id);

        return response()->json([
            'success' => true,
            'message' => 'Subscribed successfully.',
        ], 200);
    }

    /**
     * Unsubscribe from announcment price changes.
     * 
     * @param PriceRequest $request
     * @return JsonResponse
     */
    public function unsubscribe(PriceRequest $request): JsonResponse
    {
        $price = Price::where('link', $request->link)->first();

        if (empty($price)) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found.',
            ], 404);
        }

        $price->users()->detach($this->user_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Unsubscribed successfully.',
        ], 200);
    }

    /**
     * Get type from $request->link.
     * 
     * @param string $url
     * @return string
     */
    private function getType(string $url): string
    {
        // to do: get type from $url
        return 'olx';
    }
}
