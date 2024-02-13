<script>
    //profile
    function openFileInput() {
        const changeButton = document.getElementById('changeAvatar');

        switch (changeButton.innerText) {
            case "Save":
                handleUpdateAvatar();
                break;
            default:
                document.getElementById('fileInput').click();
                break;
        }
    }

    function displaySelectedImage() {
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('avatar-img');
        const changeButton = document.getElementById('changeAvatar');

        const selectedFile = fileInput.files[0];

        if (selectedFile) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(selectedFile);

            changeButton.innerText = "Save"
        }
    }

    function handleUpdateAvatar() { // when we click on save, we send post request
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];

        const formData = new FormData();
        formData.append('avatar_url', file);

        fetch('profile.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                // Check if the request was successful (status code 200)
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Parse the response as JSON or text, depending on the content type
                return response.text(); // or response.text() if it's not JSON
            })
            .then(data => {
                // Handle the data from the response
                location.reload();
            })
            .catch(error => {
                // Handle errors during the fetch operation
                console.error('Fetch error:', error);
            });
    }
    //profile
</script>