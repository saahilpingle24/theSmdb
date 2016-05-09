<!DOCTYPE html>
<html lang="en">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">    
    <body>        
        <div class="maincontent" style="background-color: #FFF; margin: auto; padding: 20px; width: 450px; border-top: 2px solid #27ae60;">
            <div class="text-center">
                Hello {{$user->name}},
                <br />
                <p>Click here to reset your password:</p>  
                <p><a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></p>          
            </div>
        </div>
    </body>
</html>