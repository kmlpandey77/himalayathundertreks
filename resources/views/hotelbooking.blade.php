
<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span class="lnr lnr-cross"></span>
    </button>

    <h3>
        {{ $hotel->name }}
        <span class="rating" style="font-size: 16px;">
            @for($i=0;$i < (int)$hotel->rating; $i++)
            <i class="fa fa-star active" style="color: #FF6D00"></i>
            @endfor

            @for($k=$i; $k < 5; $k++)
            <i class="fa fa-star" style="color: #ddd;"></i>
            @endfor
        </span>
    </h3>

    <form action="{{ route('hotelbooking', $hotel->id) }}" method="post">
        {{ csrf_field() }}
        <h4>Personal Info</h4>
        <input type="hidden" name="hotel_name" value="{{ $hotel->name }}">
        <div class="form-group">
            <input type="text" name="name" class="form-control" required="" placeholder="Full Name">
        </div>
        <div class="form-group row">
            <div class="col-sm">
                <input type="email" name="email" class="form-control" required="" placeholder="Email">
            </div>
            <div class="col-sm">
                <input type="text" name="phone" class="form-control" required="" placeholder="Phone">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm">
                <select name="group_size" class="custom-select" id="" required="">
                    <option value="">Select Group Size</option>
                    @for($i=1; $i<=12;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-sm">
                <select name="country" class="custom-select" id="" required="" >
                    <option value="">Select Country</option>
                    @foreach(App\Country::all() as $country)
                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <h4>Room Information</h4>

        <div class="form-group row">
            <div class="col-sm">
                <select name="room_category" class="custom-select" id="" required="" >
                    <option value="">Select Room Category</option>
                    <option value="Standard Room">Standard Room</option>
                    <option value="Deluxe Room">Deluxe Room</option>
                    <option value="Superior Room">Superior Room</option>
                    <option value="Suite Room">Suite Room</option>
                    <option value="Heritage Room">Heritage Room</option>
                    <option value="Club Room">Club Room</option>
                </select>
            </div>
            <div class="col-sm">
                <input type="text" name="no_of_room" class="form-control" required="" placeholder="No of Room">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm">
                <input type="text" name="first_check_in" class="form-control datepicker" required="" placeholder="1st visit check in date">
            </div>
            <div class="col-sm">
                <input type="text" name="first_check_out" class="form-control datepicker" required="" placeholder="1st visit check out date">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm">
                <input type="text" name="second_check_in" class="form-control datepicker" placeholder="2nd visit check in date">
            </div>
            <div class="col-sm">
                <input type="text" name="second_check_out" class="form-control datepicker" placeholder="2nd visit check out date">
            </div>
        </div>

        <div class="form-group">
            <input type="text" name="meal_plan" class="form-control" required="" placeholder="Meal Plan">
        </div>
        <div class="form-group">
            <textarea name="message" class="form-control" required="" placeholder="Message"></textarea>
        </div>
        <div class="form-group">
            <button class="button button-secondary button-pill">Book now</button>
        </div>
    </form>
</div>

<script>
    $(function () {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            onSelect: function(date){

                var selectedDate = new Date(date);
                var msecsInADay = 86400000;
                var endDate = new Date(selectedDate.getTime() + msecsInADay);

                $(".deparute_date").datepicker( "option", "minDate", endDate );
            }
        });

        $(".deparute_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            minDate: 0,
        });
    });
    </script>