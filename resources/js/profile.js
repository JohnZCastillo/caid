let formProfile = document.querySelector("#profile");
let profileImage = document.querySelector("#file");
let photo = document.querySelector("#photo");

const imgDiv = document.querySelector(".profile-pic-div");
imgDiv.addEventListener("mouseenter", function () {
  uploadBtn.style.display = "block";
});
imgDiv.addEventListener("mouseleave", function () {
  uploadBtn.style.display = "none";
});

profileImage.onchange = function () {
  console.log("change");
  updateProfile();
};

const updateProfile = async (event) => {
  try {
    //  1,048,576  -> 1 mb
    // limit file size of image
    if (profileImage.files[0].size > 1048576) {
      alert("Image is to big: 1mb limit.");
      return;
    }

    // save image as form data
    const form_data = new FormData();
    form_data.append("sample_image", profileImage.files[0]);

    // post first the image
    const imagePath = await fetch("./update-profile", {
      method: "POST",
      body: form_data,
    });

    // get result
    const result = await imagePath.json();

    //throw an error if response is not 200
    if (!imagePath.ok) throw new Error(result.message);

    //update profile photo
    photo.src = "./assets/profile/" + result.message;
    console.log(result.message);
    window.target.reload();
  } catch (error) {
    console.log(error.message);
  }
};
