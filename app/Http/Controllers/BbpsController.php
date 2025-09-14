<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BbpsController extends Controller
{
    private $apiKey;
    private $apiBaseUrl;
    private Client $client;

    public function __construct()
    {
        $this->apiKey     = config('services.bbps.api_key');
        $this->apiBaseUrl = config('services.bbps.api_url');
        $this->client     = new Client([
            'base_uri' => $this->apiBaseUrl,
            'headers'  => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function categories()
    {

        try {
            $response = $this->client->request('POST', "{$this->apiBaseUrl}/category_list", [
                'json' => [
                    'secret_key' => $this->apiKey,
                ],
            ]);

            $categories = json_decode($response->getBody()->getContents(), true);

            return view('bbps.categories', compact('categories'));

        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch categories.');
        }
    }

    public function billers(Request $request, $category_name)
    {
        try {

            $response = $this->client->request('POST', "{$this->apiBaseUrl}/biller_list", [
                'json' => [
                    'secret_key' => $this->apiKey,
                    'category'   => $category_name,
                ],
            ]);

            $billers = json_decode($response->getBody()->getContents(), true);

            return view('bbps.billers', compact('billers', 'category_name'));

        } catch (\Exception $e) {
            Log::error('Error fetching billers: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch billers.');
        }
    }

    public function billerInfo(Request $request, $billerId)
    {
        try {

            $response = $this->client->request('POST', "{$this->apiBaseUrl}/bbps_biller_info", [
                'json' => [
                    'secret_key' => $this->apiKey,
                    'biller_id'  => $billerId,
                ],
            ]);

            $info = json_decode($response->getBody()->getContents(), true);

            return view('bbps.biller-info', compact('info', 'billerId'));
        } catch (\Exception $e) {
            Log::error('Error fetching biller info: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch biller info.');
        }
    }

    public function fetchBillDetails(Request $request)
    {
        try {
            $billerId    = $request->input('biller_id');
            $fields      = $request->input('fields_info');
            $fieldsArray = [];
            foreach ($fields as $key => $value) {
                $fieldsArray[] = [$key => $value];
            }

            $response = $this->client->request('POST', "{$this->apiBaseUrl}/bbps_bill_fetch", [
                'json' => [
                    'secret_key'  => $this->apiKey,
                    'biller_id'   => $billerId,
                    'fields_info' => $fieldsArray,
                ],
            ]);

            $bill = json_decode($response->getBody()->getContents(), true);

            // dd($bill);

            return view('bbps.bill-details', compact('bill', 'billerId'));

        } catch (\Exception $e) {
            Log::error('Error fetching bill details: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch bill details.');
        }
    }

    public function payBill(Request $request)
    {
        try {
            $billerId    = $request->input('biller_id');
            $amount      = $request->input('amount');
            $clientRefId = $request->input('clientRefId');
            $requestId   = $request->input('RequestID');
            $orderId     = uniqid('ORD');

            // dd($billerId, $amount, $clientRefId, $requestId, $orderId);

            $response = $this->client->request('POST', "{$this->apiBaseUrl}/bbps_bill_payment", [
                'json' => [
                    'secret_key'  => $this->apiKey,
                    'biller_id'   => $billerId,
                    'clientRefId' => $clientRefId,
                    'RequestID'   => $requestId,
                    'order_id'    => $orderId,
                    'amount'      => $amount,
                ],
            ]);

            $payment = json_decode($response->getBody()->getContents(), true);

            return view('bbps.payment-status', compact('payment', 'billerId', 'orderId'));

        } catch (\Exception $e) {
            Log::error('Error paying bill: ' . $e->getMessage());
            return back()->with('error', 'Unable to process payment.');
        }
    }

}
