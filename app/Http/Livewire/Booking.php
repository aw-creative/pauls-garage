<?php

namespace App\Http\Livewire;

use DB;
use App\Models\Customer;
use App\Models\Booking as BookModel;
use App\Models\Vehicle;
use App\Services\EmailValidationService;
use App\Services\VehicleSearchService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Cmixin\BusinessTime;
use Livewire\Component;
use App\Notifications\BookingConfirmed;
use App\Notifications\AdminBookingConfirmed;

class Booking extends Component
{

    public $regnumber;
    public $make = 'Car';
    public $model = 'Car';
    public Customer $customer;
    public BookModel $booking;
    public $vehicle;
    public $emailvalid;

    public $bookinglist;
    public $futuredates;
    public $bookingStart;
    public $bookconfirmed = false;

    ///turn this on to use external service
    protected $extenalvalidation = false;

    protected $emailservice;

    protected $rules = [
        'customer.email' => 'required|email',
        'customer.name' => 'required',
        'customer.phone' => 'required',
        'bookingStart' => 'required'
    ];

    public function mount(){

        //Enable the Businesstime Mixin for Carbon business time is configurable bia the carbon config file.
        BusinessTime::enable(
            CarbonPeriod::class
        ,config('carbon.opening-hours'));

        $this->booking = new BookModel;
        $this->customer = new Customer;
        $this->emailservice = new EmailValidationService;
        //Get all dates in the future
        $dates = CarbonPeriod::create(Carbon::tomorrow()->startOfDay(),'30 Minutes' ,Carbon::now()->addDays(30)->startOfDay());
        $this->futuredates = [];
        foreach($dates as $date){
            //filter the dates to only show dates that the business is open
            if($date->isBusinessOpen()) $this->futuredates[] = $date;
        }
        $this->bookinglist = BookModel::whereDate('bookingStart' ,'>', Carbon::now())->pluck('bookingStart');

    }

    public function render()
    {
        return view('livewire.booking');
    }

    public function getVehicle()
    {
        ///Make api call to DVLA API and get the Vehicle Details and then populate the variables with that

        $vehicledata = new VehicleSearchService;
        $data = json_decode($vehicledata->search($this->regnumber),true);
        $this->vehicle = $data;
    }

    public function validateEmail()
    {
        //Internal validation to check it maches regex for email address
        $this->validateOnly('customer.email');
        ///If we want to use external email validation service this will connect to enternal api and validate it is actually a real email address.
        if($this->extenalvalidation){
            $this->emailservice = new EmailValidationService;
            $data = $this->emailservice->verify($this->customer->email);
            $this->emailvalid = $data;
            $this->addError('customer.email', 'The email field is invalid.');
        }

    }

    public function saveBooking(){
      //  $this->validate();
        $this->booking->type ="customer";
        $start = Carbon::createFromFormat('d-m-y H:i',$this->bookingStart);
        $end = Carbon::createFromFormat('d-m-y H:i',$this->bookingStart)->addMinutes(30);
        $this->booking->bookingStart = $start;
        $this->booking->bookingEnd = $end;
        $this->customer->save();
        $vehicle = new Vehicle;
        $vehicle->fill($this->vehicle);
        $this->customer->vehicle()->save($vehicle);
        $this->customer->booking()->save($this->booking);
        $this->customer->notify(new BookingConfirmed($this->booking));
        \App\Models\User::first()->notify(new AdminBookingConfirmed($this->booking));
        $this->bookconfirmed = true;
    }

}
