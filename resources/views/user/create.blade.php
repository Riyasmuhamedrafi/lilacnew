<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        .search-click {
        border: 1px solid #ccc;
        outline: none;
        background-size: 22px;
        background-position: 13px;
        border-radius: 10px;
        width: 50px;
        height: 50px;
        padding: 25px;
        transition: all 0.5s;
        }
        .search-click:focus {
        width: 300px;
        padding-left: 50px;
        }
        .search-click {
        position: relative;
        overflow: hidden;
        height: 50px;
        }
        .search-click input {
        background: transparent;
        border: 1px solid #ccc;
        outline: none;
        position: absolute;
        width: 300px;
        height: 50px;
        left: 0%;
        padding: 10px;
        }
    </style>
  </head>
  <body>
    <div class="container pt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3>Fill Details</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('customer.store')}}">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Your Name</span>
                            <input type="text" name="name" aria-label="name" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Your Phone number</span>
                            <input type="text" name="phone" aria-label="phone" class="form-control @error('phone') is-invalid @enderror" required>
                        </div>
                    </div>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="mb-3">
                        <select class="form-select @error('department') is-invalid @enderror" aria-label="Default select example" id="department" name="department">
                            <option selected disabled>Open this select menu</option>
                            @foreach ($departments as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('department')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <!-- Corrected the id attribute below -->
                    <div class="mb-3">
                        <div id="designation_all"></div>
                        @error('designation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        $(document).ready(function () {
            var propertyListDiv = $("#designation_all");

            $("#department").on('change', function() {
                let selectedDepartmentIds = $(this).val();

                if (selectedDepartmentIds.length == 0) {
                    propertyListDiv.hide();
                } else {
                    propertyListDiv.show();
                    findDesignations(selectedDepartmentIds);
                }
            });

            function findDesignations(departmentIds) {
                $.ajax({
                    type: "GET",
                    url: '{{ route("designation.index") }}',
                    data: {
                        'select_key': departmentIds,
                    },
                    success: function (data) {
                        console.log(data);

                        if (data && data.status == 200 && data.user_info.length > 0) {
                            var select = $("<select>").attr({
                                'class': 'form-select',
                                'name': 'designation',
                                'aria-label': 'Default select example',
                            });

                            $.each(data.user_info, function (index, designation) {
                                var option = $("<option>").val(designation.id).text(designation.name);
                                select.append(option);
                            });

                            propertyListDiv.empty().append(select);
                        } else {
                            // No designations found or error occurred, hide the select
                            propertyListDiv.hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error, such as showing an error message
                    }
                });
            }
        });
    </script>
  </body>
</html>
