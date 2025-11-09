@extends('backend.layout.app')
@section('title', 'Register Users')
<style>
.table-container {
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
}

.table {
    width: 100px !important;
    height: 100px;
    background-color: gray;
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px;
    border-radius: 15px;
    flex-shrink: 0; /* Prevents shrinking */
    position: relative; /* Allows for absolute positioning of circles */
}

.person {
    width: 20px;
    height: 20px;
    background-color: gray;
    border-radius: 50%;
    margin: 5px;
    flex-shrink: 0; /* Prevents shrinking */
}

.row-container {
    margin-bottom: 124px;
    margin-left: 19px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    width: calc(100% / 5 - 20px);
}

.circle-top,
.circle-bottom {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.circle-top {
    top: -40px; /* Adjust based on circle size and desired spacing */
}

.circle-bottom {
    bottom: -40px; /* Adjust based on circle size and desired spacing */
}

.circle-left,
.circle-right {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.circle-left {
    left: -40px; /* Adjust based on circle size and desired spacing */
}

.circle-right {
    right: -40px; /* Adjust based on circle size and desired spacing */
}

.custom-popup {
    width: 13% !important;
    display: none;
    position: absolute;
    z-index: 1000;
    border: 1px solid #ccc;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    padding: 10px;
    border-radius: 5px;
}

.popup-content {
    position: relative;
}

.close {
    position: absolute;
    top: 5px;
    right: 10px;
    cursor: pointer;
}


</style>

@section('content')
    <div class="mb-5">
        <div class="table-container">
            @foreach ($sitting_tables as $index => $table)
                <div class="row-container">
                    <div class="table" data-table-id="{{ $table->id }}" onclick="showPopup(this, {{ $table->id }})">
                        <div class="circle-top person"></div>
                        <div class="circle-left person"></div>
                        <div>{{ $table->name }}</div>
                        <div class="circle-right person"></div>
                        <div class="circle-bottom person"></div>
                    </div>
                </div>
                @if (($index + 1) % 5 == 0)
                    <div class="w-100"></div>
                @endif
            @endforeach
        </div>
    </div>
    <div id="customPopup" class="custom-popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h5 class="table-name"></h5>
            <select class="form-control" id="membersDropdown">
                <!-- Options will be dynamically populated -->
            </select>
        </div>
    </div>
@endsection

@section('script')
<script>
     function showPopup(element, tableId) {
        var popup = document.getElementById("customPopup");
        var rect = element.getBoundingClientRect();
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

        popup.style.top = (rect.top - 90 + scrollTop + element.offsetHeight) + "px";
        popup.style.left = (rect.left + scrollLeft) + "px";
        popup.style.display = "block";

        // Fetch the registrations for the table
        $.ajax({
            url: 'get-registrations/' + tableId,
            method: 'GET',
            success: function(data) {
                var membersDropdown = $('#membersDropdown');
                var tableName = $('.table-name');
                tableName.empty();
                tableName.html(data.sittingTable.name);
                membersDropdown.empty();
                $.each(data.registrations, function(index, registration) {
                    membersDropdown.append(new Option(registration.name, registration.id));
                });
            }
        });
    }

    function closePopup() {
        var popup = document.getElementById("customPopup");
        popup.style.display = "none";
    }

    $(document).click(function(event) { 
        if(!$(event.target).closest('.table, .custom-popup').length) {
            if($('#customPopup').is(":visible")) {
                closePopup();
            }
        }        
    });
</script>
@endsection

