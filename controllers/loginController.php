<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class loginController
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            if (empty($alertas)) {
                //Comprobar que exista el usuario
                $usuario = Usuario::where("email", $auth->email);
                if ($usuario) {
                    //Verificar password
                    if ($usuario->comprobarPasswordBerificado($auth->password)) {
                        session_start();

                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        //Redireccionar
                        if ($usuario->admin === "1") {
                            $_SESSION["admin"] = $usuario->admin ?? null;
                            header("Location: /admin");
                        } else {
                            header("Location: /cita");
                        }

                        debuguear($_SESSION);
                    }
                } else {
                    $alertas["error"][] = "Usuario no valido";
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render("auth/login", [
            "alertas" => $alertas
        ]);
    }

    public static function logout()
    {
        session_start();

        $_SESSION = [];

        header("Location: /");
    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                //verificar que el email exista
                $usuario = Usuario::where("email", $auth->email);
                if ($usuario && $usuario->confirmado === "1") {
                    //Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    //Alerta exito
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    Usuario::setAlerta("exito", "Revisa tu email");
                } else {
                    Usuario::setAlerta("error", "Correo encontrado o cuenta no confirmada");                    
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render("auth/olvide-password", [
            "alertas" => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)){
            $error = true;
            Usuario::setAlerta("error", "Token no valido"); 
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            
            if(empty($alertas)){
                $usuario-> password = null;

                
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->$token=null;

                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crearCuenta(Router $router)
   {
        $usuario = new Usuario();

        //Alertas vacias
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que alertas este vacio
            if (empty($alertas)) {
                //Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear el password
                    $usuario->hashPassword();
                    //Generar un token unico 
                    $usuario->crearToken();
                    //Enviar el correo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();


                    //Crear el usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header("Location: /mensaje");
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmarCuenta(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta("error", "Token no valido");
        } else {
            //Modificar en la base de datos
            Usuario::setAlerta("exito", "Cuenta confirmada correctamente");
            $usuario->token = null;
            $usuario->confirmado = "1";
            $usuario->guardar();
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
