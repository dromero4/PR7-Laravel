"use strict";

document.getElementById('botoEditarFotoPerfil').addEventListener('click', function(){
    // Para cambiar el boton de editar por el de guardar cambios
    if(document.getElementById('guardarCanvis').style.display === 'none'){
        document.getElementById('guardarCanvis').style.display = 'block'
        document.getElementById('botoEditarFotoPerfil').style.display = 'none';

        // Para poder editar los campos del perfil
        document.getElementById('usuariPerfil').disabled = false;
        document.getElementById('correuPerfil').disabled = false;

        if(document.getElementById('botonSubirImagen').disabled){
            document.getElementById('botonSubirImagen').disabled = false;
        }
    }

    
});
