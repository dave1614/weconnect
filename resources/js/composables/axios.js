import { ref } from 'vue'

export async function useAxios(url, loadingMsg, props) {
    const loading = ref(false)
    const error = ref(null)
    const response = ref(null)

    try {
		loading.value = true // Set loading state before making the request

		// Use a single Swal instance to avoid creating multiple instances
		const swalInstance = Swal.fire({
		title: 'Please wait',
		html: loadingMsg,
		icon: 'info',
		showConfirmButton: false,
		allowEscapeKey: false,
		allowOutsideClick: false,
		})


        response.value = await axios.post(url, null, { params: props });
        swalInstance.close() // Close the Swal instance after the request is successful

    } catch (error) {
        error.value = error

        // Close the Swal instance in case it's still open
        Swal.close()

        // Simplified error handling
        if (error.response && error.response.status === 419) {
        	document.location.reload()
        } else {
			Swal.fire({
				title: 'Ooops!',
				html: 'Something went wrong',
				icon: 'error',
			})
        }
    } finally {
    	loading.value = false // Reset loading state after the request is completed
    }

    return { response, error, loading  }
}
