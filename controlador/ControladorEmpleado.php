<?php
if (isset($_GET['cargo'])){
    if ($_GET['cargo'] == "Secretaria de comercialización"){
        echo '{
            "Clientes":{
                "Actualizar datos":["./vistas/empleados/secretaria/actualizar_cliente.html", "update"],
                "Nuevo cliente":["./vistas/empleados/secretaria/nuevo_cliente.html", "person_add"]
            },
            "Agenda":{
                "Mostrar agenda":["./vistas/empleados/secretaria/agenda.html", "schedule"],
                "Agendar cita":["./vistas/empleados/secretaria/agendar_cita.php", "add_box"]
            },
            "Solicitudes":{
                "Solicitudes":["./vistas/empleados/secretaria/solicitudes.html", "list"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Agente inmobiliario"){
        echo '{
            "Agenda":{
                "Agenda":["./vistas/empleados/agente/agenda.html", "schedule"]
            },
            "Propiedades":{
                "Catalogo":["./vistas/empleados/agente/propiedades.php", "house"],
                "Nueva propiedad":["./vistas/empleados/agente/nueva_propiedad.html", "add"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Empleado de marketing"){
        echo '{
            "Propiedades":{
                "Catalogo":["./vistas/empleados/marketing/propiedades.html", "house"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Cajera"){
        echo '{
            "Caja":{
                "Alquiler":["./vistas/empleados/cajera/caja_alquiler.html", "attach_money"],
                "Venta":["./vistas/empleados/cajera/caja_venta.html", "handshake"],
                "Cerrar caja":["./vistas/empleados/cajera/cierre_caja.html", "point_of_sale"]
            },
            "Movimientos":{
                "Entradas y salidas":["./vistas/empleados/cajera/entrada_salida.html", "sync_alt"],
                "Movimientos de caja":["./vistas/empleados/cajera/movimientos.html", "handshake"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Jefa de administración"){
        echo '{
            "Clientes":{
                "Clientes":["./vistas/empleados/jefa_de_administracion/clientes.html", "group"]
            },
            "Transacciones":{
                "Transacciones":["./vistas/empleados/jefa_de_administracion/transacciones.html", "attach_money"],
                "Reportes":["./vistas/empleados/jefa_de_administracion/reportes.html", "list_alt"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Jefa de comercialización"){
        echo '{
            "Agenda":{
                "Agenda":["./vistas/empleados/jefa_de_comercializacion/agenda.html", "schedule"]
            },
            "Reportes":{
                "Venta":["./vistas/empleados/jefa_de_comercializacion/reportes_venta.html", "handshake"],
                "Alquiler":["./vistas/empleados/jefa_de_comercializacion/reportes_alquiler.html", "attach_money"],
                "Clientes":["./vistas/empleados/jefa_de_comercializacion/reportes_clientes.html", "group"],
                "Propiedades":["./vistas/empleados/jefa_de_comercializacion/reportes_propiedades.html", "house"]
            },
            "Clientes":{
                "Clientes":["./vistas/empleados/jefa_de_comercializacion/clientes.html", "group"]
            },
            "Propiedades":{
                "Catalogo":["./vistas/empleados/jefa_de_comercializacion/propiedades.html", "house"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Administrador"){
        echo '{
            "Empleados":{
                "Agregar":["./vistas/empleados/administrador/agregar_empleado.html", "person_add"],
                "Deshabilitar":["./vistas/empleados/administrador/deshabilitar_empleado.html", "person_remove"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Gerente general"){
        echo '{
            "Reportes":{
                "Reportes":["./vistas/empleados/gerente/reportes.html", "monitoring"]
            }
        }';
    }
}
else if(isset($_GET['cerrar_sesion'])){
    $opciones = [
        "expires" => -1,
        "path" => substr($_SERVER["PHP_SELF"],0,-36),
        "samesite" => "strict"
    ];
    setcookie("empleado", "", $opciones);
}
else require_once("./vistas/plantilla_empleado.html");
?>