<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login & Registration form</title>
    {{Html::style('assets/css/bootstrap-min.css')}}
    {{Html::style('assets/css/login-regi.css')}}
    {{Html::style('assets/css/animate-custom.css')}}

  </head>
  <body>
    <div class="container">
      <section>
        <div id="container_demo">
          <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
          <a class="hiddenanchor" id="toregister"></a> <a class="hiddenanchor" id="tologin"></a>
          <div id="wrapper">
            <div class="animate form" id="login">
              <form action="mysuperscript.php" autocomplete="on">
                <h1>Log in</h1>
                <p><label class="uname" data-icon="u" for="username">Your email or username</label> <input id="username" name="username" placeholder="myusername or mymail@mail.com" required="required" type="text"></p>
                <p><label class="youpasswd" data-icon="p" for="password">Your password</label> <input id="password" name="password" placeholder="eg. X8df!90EO" required="required" type="password"></p>
                <p class="keeplogin"><input id="loginkeeping" name="loginkeeping" type="checkbox" value="loginkeeping"> <label for="loginkeeping">Keep me logged in</label></p>
                <p class="login button"><input type="submit" value="Login"></p>
                <p class="change_link">Not a member yet ? <a class="to_register" href="#toregister">Join us</a></p>
              </form>
            </div>
            <div class="animate form" id="register">
              <form action="mysuperscript.php" autocomplete="on">
                <h1>Sign up</h1>
                <p><label class="uname" data-icon="u" for="usernamesignup">Your username</label> <input id="usernamesignup" name="usernamesignup" placeholder="mysuperusername690" required="required" type="text"></p>
                <p><label class="youmail" data-icon="e" for="emailsignup">Your email</label> <input id="emailsignup" name="emailsignup" placeholder="mysupermail@mail.com" required="required" type="email"></p>
                <p><label class="youpasswd" data-icon="p" for="passwordsignup">Your password</label> <input id="passwordsignup" name="passwordsignup" placeholder="eg. X8df!90EO" required="required" type="password"></p>
                <p><label class="youpasswd" data-icon="p" for="passwordsignup_confirm">Please confirm your password</label> <input id="passwordsignup_confirm" name="passwordsignup_confirm" placeholder="eg. X8df!90EO" required="required" type="password"></p>
                <p class="signin button"><input type="submit" value="Sign up"></p>
                <p class="change_link">Already a member ? <a class="to_register" href="#tologin">Go and log in</a></p>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>

  </body>
</html>
