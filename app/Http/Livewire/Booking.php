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
    public $emailid;
    public $bookinglist;
    public $unavailables;
    public $futuredates;
    public $timeslots;
    public $bookingStart;
    public $bookingTime;
    public $bookconfirmed = false;

    protected $emailservice;

    protected $rules = [
        'customer.email' => 'required|email',
        'customer.name' => 'required',
        'customer.phone' => 'required',
        'bookingStart' => 'required|not_in:Please Select',
        'vehicle.make' =>' required',
        'vehicle.model' =>' required',
        'vehicle.yearOfManufacture' =>' required'
    ];

    public function mount(){

        //Enable the Businesstime Mixin for Carbon, Business time is configurable via the carbon config file.
        BusinessTime::enable(
            CarbonPeriod::class
        ,config('carbon.opening-hours'));

        $this->booking = new BookModel;
        $this->customer = new Customer;
        $this->emailservice = new EmailValidationService;
        //Get all dates in the future
        $dates = CarbonPeriod::create(Carbon::tomorrow()->midDay(),'1 day' ,Carbon::now()->addDays(30)->midDay());
        $this->futuredates = [];
        $this->timeslots = [];
        $this->unavailables = Bookmodel::where('type','internal')->pluck('bookingDay');
        foreach($dates as $date){
            //filter the dates to only show dates that the business is open
            if($date->isBusinessOpen()) $this->futuredates[] = $date;
        }


    }

    public function render()
    {
        return view('livewire.booking');
    }

    public function gettimeslots(){
        $this->bookinglist = Bookmodel::whereDate('bookingDay' ,'=',Carbon::createFromFormat('d-m-y',$this->bookingStart))->pluck('bookingTime');
        $this->timeslots = [
            '09:00',
            '09:30',
            '10:00',
            '11:00',
            '12:00',
            '12:30',
            '13:00',
            '13:30',
            '14:00',
            '14:30',
            '15:00',
            '15:30',
            '16:00',
            '16:30',
        ];
    }

    public function manualvehicle(){
        $this->vehicle = ['Make' => null, 'Model' => null];
    }

    public function getVehicle()
    {
        ///Make api call to DVLA API and get the Vehicle Details and then populate the variables with that
        $vehicledata = new VehicleSearchService;
        $data = json_decode($vehicledata->search($this->regnumber),true);
        $this->vehicle = $data;
        $this->vehicle['model'] = null;
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function validateEmail()
    {
        //Internal validation to check it maches regex for email address
        ///If we want to use external email validation service this will connect to enternal api and validate it is actually a real email address.

            $this->emailservice = new EmailValidationService;
            $data = $this->emailservice->verify($this->customer->email);
            $this->emailvalid = $data;
            $this->addError('customer.email', 'The email is not a real email address');


    }

    public function saveBooking(){

        //Validate the Email using third party I picked a free one,,, its slow So worth converting to using Data8 or similar that offers better speeds
        $this->validate();
        $this->validateEmail();
        $this->booking->type ="customer";
        $start = Carbon::createFromFormat('d-m-y',$this->bookingStart);
        $time = Carbon::createFromFormat('H:i',$this->bookingTime);
        $this->booking->bookingDay = $start;
        $this->booking->bookingTime = $time;
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
