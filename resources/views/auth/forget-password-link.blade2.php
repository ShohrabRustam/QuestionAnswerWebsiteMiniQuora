<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="icon" href="https://thumbs.dreamstime.com/b/vn-logo-design-initial-letter-sci-fi-style-game-esport-technology-digital-community-business-v-n-sport-modern-italic-192979294.jpg" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">


</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center align-items-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
						<img src="https://github.com/Shubhamlmp/vragen/blob/main/mForumlogo.png?raw==true" alt="bootstrap 4 login page">
					</div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Reset Password</h4>
                            <form action="{{ route('ResetPasswordPost') }}" method="POST" class="my-login-validation" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email_address">E-Mail Address</label>
                                    <input id="email_address" type="email" class="form-control" name="email" value="{{old('email')}}" required>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="new-password">New Password</label>
                                    <input id="new-password" type="password" class="form-control" name="password" required autofocus data-eye>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                    <div class="form-text text-muted">
                                        Make sure your password is strong and easy to remember
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="new-password">Confirm Password</label>
                                    <input id="new-password" type="password" class="form-control" name="password" required autofocus data-eye>
                                    <div class="invalid-feedback">
                                        Confirm Password is required
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Reset Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; 2022 &mdash; mForum
                    </div>
                </div>
            </div>
        </div>
    </section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>

</html>