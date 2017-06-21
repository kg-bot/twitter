<h3>Register</h3>
<form action={{ url.get('register/') }} method="post">
  <div class="form-group">
    {{ form.render('email') }}
  </div>
  <div class="form-group">
    {{ form.render('password') }}
  </div>
  <div class="form-group">
    {{ form.render("confirmPassword") }}
  </div>
  <div class="form-group">
    {{ form.render('csrf') }}
  </div>
  {{ form.render('Register') }}
</form>