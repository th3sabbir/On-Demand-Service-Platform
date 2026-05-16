<?php

namespace App\Http\Controllers;

use Modules\GlobalSetting\Entities\GlobalSetting;
use Modules\GlobalSetting\app\Models\Currency;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Product\app\Models\Product;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\PackageTrx;
use Illuminate\Http\RedirectResponse;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Modules\Product\app\Models\Book;
use Modules\Leads\app\Models\Payments;
use Modules\Communication\app\Http\Controllers\EmailController;
use Modules\Communication\app\Models\Templates;
use App\Models\Bookings;
use Modules\Communication\app\Http\Controllers\NotificationController;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;
use Modules\GlobalSetting\app\Models\SubscriptionPackage;
use App\Repositories\Contracts\StripeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StripeRequest;
use App\Http\Requests\StripepaymentRequest;
use Illuminate\Support\Js;

class StripeController extends Controller
{
     protected $stripeRepository;

    public function __construct(StripeRepositoryInterface $stripeRepository)
    {
        $this->stripeRepository = $stripeRepository;
    }

    /**
     * @return View|Factory|Application
     */
    public function checkout(): View|Factory|Application
    {
        return view('bookingfail');
    }

    public function live_mobile(Request $request): JsonResponse
    {
        $response = $this->stripeRepository->live_mobile($request);
        return $response;
    }

    public function live_mobile_pay(StripeRequest $request): JsonResponse
    {
        $response = $this->stripeRepository->live_mobile_pay($request);
        return $response;
    }

    public function sub_payment_success(StripepaymentRequest $request): JsonResponse
    {
        $response = $this->stripeRepository->sub_payment_success($request);
        return $response;
    }

    /**
     * @return RedirectResponse
     * @throws ApiErrorException
     */
    public function test(Request $request): RedirectResponse
    {
        $response = $this->stripeRepository->test($request);
        return $response;
    }

    /**
     * @return RedirectResponse
     * @throws ApiErrorException
     */
    public function live(): RedirectResponse
    {
        $response = $this->stripeRepository->live();
        return $response;
    }

    /**
     * @return View|Factory|Application
     */
    public function paymentSuccess(Request $request): View|Factory|Application
    {
        $response = $this->stripeRepository->paymentSuccess($request);
        return $response;
    }

    public function stripepayment(Request $request): RedirectResponse
    {
        $response = $this->stripeRepository->stripepayment($request);
        return $response;
    }
    
    /**
     * @return View|Factory|Application
     */
    public function subscriptionpaymentsuccess(Request $request): View|Factory|Application
    {
        $response = $this->stripeRepository->subscriptionpaymentsuccess($request);
        return $response;
    }
    public function UserstripeSuccesspayment(Request $request): View|Factory|Application
    {
        Stripe::setApiKey(config('stripe.test.sk'));
        $sessionId = $request->get('session_id');
        Payments::where('transaction_id', $sessionId)->update(['status' => 2]);
        return view('user.userpaymentsuccess');
    }
}
