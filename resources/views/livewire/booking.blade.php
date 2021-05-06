<div>
    <div class="w-full">
    @if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

    @if(!$bookconfirmed)
    <form wire:submit.prevent="saveBooking" class="bg-gray-300 p-4">
    {{-- Because she competes with no one, no one can compete with her. --}}
    <span class="text-md">Search for Vehicle By Registration</span>
    <label class="text-md flex items-center my-2">
    <input wire:model.lazy="regnumber" class="bg-yellow-300 uppercase p-4 w-full h-16 rounded-md rounded-r-none border-l-1 border border-r-0 border-blue-800 font-bold text-xl"/>
    <span wire:click="getVehicle" class="cursor-pointer bg-green-500 p-4 rounded-md rounded-l-none h-16 border border-l-0 border-blue-800 text-xl text-white"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg></span>
    </label>
    @dump($vehicle)
    @if($vehicle)
    @endif
    <div class="w-full my-4">
    <label class="w-full flex items-center"> Name
    @error('customer.name'))<span class="text-red">{{$message}}}}</span>@enderror
    <input type="text" wire:model.lazy='customer.name' class="ml-auto w-2/3 @if($emailvalid) border-green-400 @endif ">
    </label>
    </div>
    <div class="w-full my-4">
    <label class="w-full flex items-center"> Email Address
        @error('customer.email'))<span class="text-red">{{$message}}</span>@enderror
    <input type="email" wire:model.lazy='customer.email' class="ml-auto w-2/3 @if($emailvalid) border-green-400 @endif ">
    </label>
</div>
<div class="w-full my-4">
    <label class="w-full flex items-center"> Phone Number
        @error('customer.phone'))<span class="text-red">{{$message}}}}</span>@enderror
        <input type="text" wire:model.lazy='customer.phone' wire:change="validateEmail" class="ml-auto w-2/3 @if($emailvalid) border-green-400 @endif ">
    </label>
</div>
<div class="w-full my-4">
    <label class="w-full flex items-center"> Time Slot
    <select class="ml-auto w-2/3" wire:model="bookingStart">
        <option value="" selected >Please Select</option>
    @foreach($futuredates as $date)
        <option @if(in_array(Carbon\Carbon::parse($date),$bookinglist->toArray())) disabled @endif >{{Carbon\Carbon::parse($date)->format('d-m-y H:i')}}</option>
    @endforeach
    </select>
</div>
</div>
    <button class="rounded-md p-4 bg-green-500 hover:bg-green-400"> Make Booking </button>
</form>
@else
    <h1 class="text-green-600 text-xl6">Booking Confirmed</h1>

@endif
</div>
</div>
