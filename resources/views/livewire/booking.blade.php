<div>
    <div class="w-full">


    @if(!$bookconfirmed)
    <form wire:submit.prevent="saveBooking" class="bg-gray-300 p-4">
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="mb-3">
    <span class="text-md">Search for Vehicle By Registration</span>
    <label class="text-md flex items-center my-2">
    <input wire:model.lazy="regnumber" class="bg-yellow-300 uppercase p-4 w-full h-16 rounded-md rounded-r-none border-l-1 border border-r-0 border-blue-800 font-bold text-xl"/>
    <span wire:click="getVehicle" class="cursor-pointer bg-green-500 p-4 rounded-md rounded-l-none h-16 border border-l-0 border-blue-800 text-xl text-white"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg></span>
    </label>
    <span class="text-sm text-gray-600 underline cursor-pointer hover:text-green-800" wire:click="manualvehicle">Enter Vehicle Details Manually </span>
</div>
    @if($vehicle || $errors->has('vehicle.make'))
    <div>
    <span class="text-xl"> Your Vehicle </span>
    <div class="w-full my-4">
        @error('vehicle.make')<span class="text-red-500">{{$message}}</span>@enderror
        <label class="w-full flex items-center"> Vehicle Make
        <input type="text" wire:model.lazy='vehicle.make' class="ml-auto w-2/3 ">
        </label>
    </div>
    <div class="w-full my-4">
        @error('vehicle.model')<span class="text-red-500">{{$message}}</span>@enderror
        <label class="w-full flex items-center"> Vehicle Model

        <input type="text" wire:model.lazy='vehicle.model' class="ml-auto w-2/3 ">
        </label>
    </div>
    <div class="w-full my-4">
        @error('vehicle.yearOfManufacture')<span class="text-red-500">{{$message}}</span>@enderror
        <label class="w-full flex items-center"> Vehicle Year
        <input type="text" wire:model.lazy='vehicle.yearOfManufacture' class="ml-auto w-2/3 ">
        </label>
    </div>
</div>
    @endif
    <span class="text-xl"> Your Contact Details </span>
    <div class="w-full my-4">
        @error('customer.name')<span class="text-red-500">{{$message}}</span>@enderror
        <label class="w-full flex items-center"> Name
        <input type="text" wire:model.lazy='customer.name' class="ml-auto w-2/3 ">
    </label>
    </div>
    <div class="w-full my-4">
        @error('customer.email')<span class="text-red-500">{{$message}}</span>@enderror
    <label class="w-full flex items-center"> Email Address

    <input type="email" wire:model.lazy='customer.email' class="ml-auto w-2/3">
    </label>
</div>
<div class="w-full my-4">
    @error('customer.phone')<span class="text-red-500">{{$message}}</span>@enderror
    <label class="w-full flex items-center"> Phone Number

        <input type="text" wire:model.lazy='customer.phone'  class="ml-auto w-2/3">
    </label>
</div>
<span class="text-xl"> Select Your Time Slot </span>
<div class="w-full my-4">
    @error('bookingStart')<span class="text-red-500">{{$message}}</span>@enderror
    <label class="w-full flex items-center"> Date
    <select class="ml-auto w-2/3" wire:model="bookingStart" wire:change="gettimeslots">
        <option value="" selected >Please Select</option>
    @foreach($futuredates as $date)
    <option @if(in_array(Carbon\Carbon::parse($date)->format('Y-m-d'),$unavailables->toArray())) disabled @endif >{{Carbon\Carbon::parse($date)->format('d-m-y')}}</option>
    @endforeach
    </select>
</div>

    @if($bookingStart)
    <div class="w-full my-4">
        <label class="w-full flex items-center"> Time
    <select class="ml-auto w-2/3" wire:model="bookingTime">
        <option value="" selected >Please Select</option>
    @foreach($timeslots as $date)
        <option @if(in_array(Carbon\Carbon::parse($date)->format('H:i:s'),$bookinglist->toArray())) disabled @endif >{{Carbon\Carbon::parse($date)->format('H:i')}}</option>
    @endforeach
    </select>
</div>
    @endif
</div>
    <button class="rounded-md p-4 bg-green-500 hover:bg-green-400 w-full mt-6">
        <svg wire:loading wire:target="saveBooking" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Make Booking </button>
</form>
@else
    <h1 class="text-green-600 text-xl6">
    </div> Booking Confirmed</h1>

@endif
</div>
</div>
