<?=$this->loginFailed ? "<p class=\"error\">Revisa l'adreça de correu i/o la contrassenya</p>" : ""?>
<!-- Formulari de Login -->
<form method="POST" action="/">
    <label for="iEmail">Email</label>
    <input id="iEmail" name="user" type="email" value="<?=$this->email ?>" required />
    <label for="iPass">Password</label>
    <input id="iPass" name="pass" type="password" required />
    <button class="button" type="submit"><span>Login</span></button>
</form>
