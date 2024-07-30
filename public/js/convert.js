document.getElementById('convertForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    
    document.getElementById('statusMessage').classList.remove('hidden');
    document.getElementById('downloadLink').classList.add('hidden');

    fetch(form.action, {
        method: form.method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const contentDisposition = response.headers.get('Content-Disposition');
        let originalFileName = 'converted.wav';

        if (contentDisposition && contentDisposition.includes('filename=')) {
            originalFileName = contentDisposition.split('filename=')[1].replace(/['"]/g, '');
        }

        return response.blob().then(blob => ({ blob, originalFileName }));
    })
    .then(({ blob, originalFileName }) => {
        const url = window.URL.createObjectURL(blob);
        const link = document.getElementById('convertedFileLink');
        link.href = url;
        link.download = originalFileName;
        document.getElementById('statusMessage').classList.add('hidden');
        document.getElementById('downloadLink').classList.remove('hidden');
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        document.getElementById('statusMessage').textContent = 'Conversion failed. Please try again.';
    });
});
