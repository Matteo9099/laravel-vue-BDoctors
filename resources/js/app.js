require('./bootstrap');


const deleteDoctorProfile = document.querySelector('.delete-profile');
if(deleteDoctorProfile){
    deleteDoctorProfile.addEventListener('click',
        (e)=>{
            if(!confirm('Vuoi davvero eliminare il profilo del dottore?')){
                e.preventDefault();
            }
        }
    )
}

const deleteUserProfile = document.getElementById('deleteUser');
if(deleteUserProfile){
    deleteUserProfile.addEventListener('click',
        (e)=>{
            if(!confirm('Vuoi davvero eliminare il profilo?')){
                e.preventDefault();
            }
        }
    )
}

const deleteUserPhoto = document.getElementById('deletePhoto');
if(deleteUserPhoto){
    deleteUserPhoto.addEventListener('click',

        (e)=>{
            if(!confirm('Vuoi eliminare la foto profilo?')){
                e.preventDefault();
            }
        }

    )
}
