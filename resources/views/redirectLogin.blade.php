<form action="/redirectLogin" method="POST">
    @csrf()
    <input type="text" name="email">
    <input type="password" name="password">
    <input type="submit" value="login">
</form>
