<?php
if (isset($_GET['cargo'])){
    if ($_GET['cargo'] == "Secretaria de comercialización"){
        echo '{
            "clientes":{
                "actualizar datos":["./vistas/empleados/secretaria/actualizar_cliente.html", "update"],
                "nuevo cliente":["./vistas/empleados/secretaria/nuevo_cliente.html", "person_add"]
            },
            "agenda":{
                "mostrar agenda":["./vistas/empleados/secretaria/agenda.html", "schedule"],
                "agendar cita":["./vistas/empleados/secretaria/agendar_cita.html", "add_box"]
            },
            "solicitudes":{
                "solicitudes":["./vistas/empleados/secretaria/solicitudes.html", "list"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Agente inmobiliario"){
        echo '{
            "agenda":{
                "agenda":["./vistas/empleados/agente/agenda.html", "schedule"]
            },
            "propiedades":{
                "catalogo":["./vistas/empleados/agente/propiedades.html", "house"],
                "nueva propiedad":["./vistas/empleados/agente/nueva_propiedad.html", "add"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Empleado de marketing"){
        echo '{
            "propiedades":{
                "catalogo":["./vistas/empleados/marketing/propiedades.html", "house"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Cajera"){
        echo '{
            "caja":{
                "alquiler":["./vistas/empleados/cajera/caja_alquiler.html", "attach_money"],
                "venta":["./vistas/empleados/cajera/caja_venta.html", "handshake"],
                "cerrar caja":["./vistas/empleados/cajera/cierre_caja.html", "point_of_sale"]
            },
            "movimientos":{
                "entradas y salidas":["./vistas/empleados/cajera/entrada_salida.html", "sync_alt"],
                "movimientos de caja":["./vistas/empleados/cajera/movimientos.html", "handshake"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Jefa de administración"){
        echo '{
            "clientes":{
                "clientes":["./vistas/empleados/jefa_de_administracion/clientes.html", "group"]
            },
            "transacciones":{
                "transacciones":["./vistas/empleados/jefa_de_administracion/transacciones.html", "attach_money"],
                "reportes":["./vistas/empleados/jefa_de_administracion/reportes.html", "list_alt"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Jefa de comercialización"){
        echo '{
            "agenda":{
                "agenda":["./vistas/empleados/jefa_de_comercializacion/agenda.html", "schedule"]
            },
            "reportes":{
                "venta":["./vistas/empleados/jefa_de_comercializacion/reportes_venta.html", "handshake"],
                "alquiler":["./vistas/empleados/jefa_de_comercializacion/reportes_alquiler.html", "attach_money"],
                "clientes":["./vistas/empleados/jefa_de_comercializacion/reportes_clientes.html", "group"],
                "propiedades":["./vistas/empleados/jefa_de_comercializacion/reportes_propiedades.html", "house"]
            },
            "clientes":{
                "clientes":["./vistas/empleados/jefa_de_comercializacion/clientes.html", "group"]
            },
            "propiedades":{
                "catalogo":["./vistas/empleados/jefa_de_comercializacion/propiedades.html", "house"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Administrador"){
        echo '{
            "empleados":{
                "agregar":["./vistas/empleados/administrador/agregar_empleado.html", "person_add"],
                "deshabilitar":["./vistas/empleados/administrador/deshabilitar_empleado.html", "person_remove"]
            }
        }';
    }
    else if ($_GET['cargo'] == "Gerente general"){
        echo '{
            "reportes":{
                "reportes":["./vistas/empleados/gerente/reportes.html", "monitoring"]
            }
        }';
    }
}
else if(isset($_GET['cerrar_sesion'])){
    $opciones = [
        "expires" => -1,
        "path" => substr($_SERVER["PHP_SELF"],0,-36),
        "samesite" => "none"
    ];
    setcookie("empleado", "", $opciones);
}
else require_once("./vistas/plantilla_empleado.html");
?>