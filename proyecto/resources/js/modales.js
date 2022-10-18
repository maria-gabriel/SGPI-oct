function fok() {
    setTimeout(() => {
        $("#successToast").toast("show");
    }, 200);
}

function fnok(){
    setTimeout(() => {
        $("#dangerToast").toast("show");
    }, 200);
}