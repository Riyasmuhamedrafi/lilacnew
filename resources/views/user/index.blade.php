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
                <input type="text" class="search-click" name="" id="search" placeholder="search here..." />
            </div>
            <div class="card-body">
                @if (count($users)>0)
                <div class="row row-cols-1 row-cols-md-2 g-4 pt-3" id="user_found">
                    @foreach ($users as $item)
                    <div class="col">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">{{$item->name}}</h5>
                            <p class="card-text">{{$item->department_name}}</p>
                            <p class="card-text">{{$item->designation_name}}</p>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row" id="no_user">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                              <h5 class="card-title text-center">-------- No Users --------</h5>
                            </div>
                          </div>
                    </div>
                </div>
                @endif

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
         $(document).ready(function() {
            $('#search').on('keyup', function() {
                var inputValue = $(this).val();
                showHint(inputValue);
            });
        });
        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("search").innerHTML = "";
                return;
            }
            var input = str;
            $.ajax({
                type:'GET',
                url:"{{ route('customer.index') }}",
                data:{search_key:input},
                success:function(data){
                        if(data.status == 404)
                        {
                            $('#user_found').css('display', 'none');
                            $('#no_user').css('display', 'block');
                            var html = '<p style="color:red">* Invalid OTP Or Mobile</p>';
                            $('#no_user_flow').html(html);
                        }
                        else{
                            $('#no_user').css('display', 'none');
                            $('#user_found').css('display', 'block');
                            // Select the element where you want to insert the user information
                            var userContainer = document.getElementById('user_found');

                            // Clear existing content
                            userContainer.innerHTML = '';

                            // Loop through each user in the user_info array
                            data.user_info.forEach(function(user) {
                                // Create the necessary HTML elements
                                var divCol = document.createElement('div');
                                divCol.classList.add('col');

                                var card = document.createElement('div');
                                card.classList.add('card');

                                var cardBody = document.createElement('div');
                                cardBody.classList.add('card-body');

                                var cardTitle = document.createElement('h5');
                                cardTitle.classList.add('card-title');
                                cardTitle.textContent = user.name;

                                var departmentText = document.createElement('p');
                                departmentText.classList.add('card-text');
                                departmentText.textContent = user.department.name;

                                var designationText = document.createElement('p');
                                designationText.classList.add('card-text');
                                designationText.textContent = user.designation.name;

                                // Append elements to build the structure
                                cardBody.appendChild(cardTitle);
                                cardBody.appendChild(departmentText);
                                cardBody.appendChild(designationText);
                                card.appendChild(cardBody);
                                divCol.appendChild(card);

                                // Append the constructed card to the container
                                userContainer.appendChild(divCol);
                            });

                        }
                    },
                    error:function(){
                        var html = '<p style="color:red">* -------- No Users --------</p>';
                        $('#custom_update_content').html(html);
                    }
                });
        }
    </script>
  </body>
</html>
