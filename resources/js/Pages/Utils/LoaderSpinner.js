export function LoaderSpinner () {
    Swal.fire({
        title: 'Saving...',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading()
        }
      })
}