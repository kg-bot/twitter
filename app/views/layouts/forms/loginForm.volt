<h3>Login</h3>
<form action= {{ url.get('login/') }} method="post">
  <div class="form-group">
    {{ loginForm.render('loginEmail') }}
  </div>
  <div class="form-group">
    {{ loginForm.render('loginPassword') }}
  </div>
  <div class="form-group">
    {{ loginForm.render('csrf') }}
  </div>
  {{ loginForm.render('Login') }}
</form>