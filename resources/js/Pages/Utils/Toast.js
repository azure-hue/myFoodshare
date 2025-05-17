export function showErrorToast() {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please fill all the fields!',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6',
    })
}

export function showSuccessToast() {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Recipe added successfully!',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6',
    })
}

export function axiosErrorToast(msg="Error") {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: msg,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6',
    })
}


export function SuccessToast(msg='success') {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: msg,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6',
    })
}

export function ConfirmToast(msg='Are you Sure!!!') {
    Swal.fire({
        icon: 'success',
        title: 'Confirmation!',
        text: msg,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6',
    })
}