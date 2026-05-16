<?php

namespace App\Http\Controllers;

use app\Http\Controllers;
use Modules\GlobalSetting\app\Models\Placeholders;
use Modules\Categories\app\Models\Categories;
use App\Models\Bookings;
use App\Models\Branches;
use App\Models\Dispute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Models\PayoutHistory;
use App\Models\UserDetail;
use App\Models\WalletHistory;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Support\Carbon;
use Modules\Communication\app\Http\Controllers\EmailController;
use Modules\Communication\app\Http\Controllers\NotificationController;
use Modules\Communication\app\Models\Templates;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Modules\GlobalSetting\app\Models\Currency;
use Modules\Product\app\Models\Product;
use Modules\GlobalSetting\Entities\GlobalSetting;
use Modules\Product\app\Models\Productmeta as ModelsProductmeta;
use Modules\Service\app\Models\AdditionalService;
use Modules\Service\app\Models\Productmeta;
use Modules\Service\app\Models\Service;
use Modules\GoogleCalendarSync\app\Http\Controllers\GoogleCalendarSyncController;

class BookingController extends Controller
{
    protected BookingRepositoryInterface $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index()
    {
        $data = $this->bookingRepository->index();
        // return response()->json($data, 200);
        return view('booking.bookinglist', $data);
    }

    public function userBookinglist()
    {
        $response = $this->bookingRepository->userBookinglist();
        return response()->json($response, 200);
    }

    public function providerindex(Request $request): JsonResponse | View
    {
        $data = $this->bookingRepository->providerindex($request);
        if (request()->has('is_mobile') && request()->get('is_mobile') === "yes") {
            if ($data['bookingdata']->isEmpty()) {
                return response()->json(['code' => 200, 'message' => "Booking list details not found", 'data' => []], 200);
            }
            return response()->json(['code' => 200, 'message' => "Booking list fetched successfully", 'data' => $data], 200);
        } else {
            return view('provider.booking.bookinglist', compact('data'));
        }
    }

    public function staffindex(Request $request): JsonResponse | View
    {
        $data = $this->bookingRepository->staffindex($request);

        if (request()->has('is_mobile') && request()->get('is_mobile') === "yes") {
            if ($data['bookingdata']->isEmpty()) {
                return response()->json(['code' => 200, 'message' => "Booking list details not found", 'data' => []], 200);
            }
            return response()->json(['code' => 200, 'message' => "Booking list fetched successfully", 'data' => $data], 200);
        } else {
            return view('staff.bookinglist', compact('data'));
        }
    }

    public function updatebookingstatus(Request $request): JsonResponse
    {
        $response = $this->bookingRepository->updateBookingStatus($request);
        return response()->json($response, $response['code']);
    }

    public function calenderview(): View
    {
        return view('admin.booking.calendar');
    }

    public function getBookings(Request $request): JsonResponse
    {
        $bookings = $this->bookingRepository->getBookings($request);
        return $bookings;
    }

    public function listindex(Request $request): View
    {
        return view('admin.booking.list');
    }

    public function getBookinglists(Request $request): JsonResponse
    {
        $data = $this->bookingRepository->getBookinglists($request);
        return response()->json($data, $data['code']);
    }

    public function indexRequest(Request $request): JsonResponse
    {
        $data = $this->bookingRepository->indexRequest($request);
        return response()->json($data, $data['code']);
    }

    public function requestDispute(Request $request): JsonResponse
    {
        return $this->bookingRepository->requestDispute($request);
    }

    public function requestDisputeApi(Request $request): JsonResponse
    {
        return $this->bookingRepository->requestDisputeApi($request);
    }

    public function UpdateRequest(Request $request): JsonResponse
    {
        return $this->bookingRepository->UpdateRequest($request);
    }

    public function getDisputeDetails(Request $request)
    {
        $response = $this->bookingRepository->getDisputeDetails($request);
        return response()->json($response);
    }

    public function getDisputeDetailsApi(Request $request)
    {
        return $this->bookingRepository->getDisputeDetailsApi($request);
    }

    public function getDisputeInfo(Request $request)
    {
        return $this->bookingRepository->getDisputeInfo($request);
    }

    public function getBookingDetails(Request $request)
    {
        return $this->bookingRepository->getBookingDetails($request);
    }

    public function WalletCheck(Request $request)
    {
        $response = $this->bookingRepository->WalletCheck($request);
        return response()->json($response, $response['code']);
    }
    
    /**
     * Cancel Google Calendar event for a booking

     */
    public function cancelCalendarEvent(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|integer|exists:bookings,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid booking ID',
                'errors' => $validator->errors()
            ], 400);
        }
        try {
            $booking = Bookings::find($request->booking_id);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            $googleCalendarController = new GoogleCalendarSyncController();
            $result = $googleCalendarController->cancelGoogleCalendarEvent($booking);

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Calendar event cancelled successfully' : 'Failed to cancel calendar event'
            ], $result ? 200 : 400);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling calendar event: ' . $e->getMessage()
            ], 500);
        }
    }
}
