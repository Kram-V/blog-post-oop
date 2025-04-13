<h1>403 - Forbidden</h1>
<p>You dont have permissions to access this resource</p>

<p>
  <?php if(App\Services\Auth::user() !== null): ?>
    <?php if(App\Services\Auth::user()->role === 'admin'): ?>
      <a href="/admin/home">Return to Dashboard</a>
    <?php else: ?>
      <a href="/">Return to Homepage</a>
    <?php endif; ?>
  <?php else: ?>
    <a href="/login">Return to Login Page</a>
  <?php endif; ?>
</p>