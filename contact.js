/*document.getElementById('addContactBtn').addEventListener('click', function () {
    // Get the input values
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;

    // Check if inputs are not empty
    if (name === '' || phone === '') {
        alert('Please enter both name and phone number');
        return;
    }

    // Create a new list item for the contact
    const li = document.createElement('li');
    li.innerHTML = `
        <span class="name">${name}</span> - <span class="phone">${phone}</span>
        <button class="delete-btn">Delete</button>
    `;

    // Add the new contact to the contact list
    document.getElementById('contactList').appendChild(li);

    // Clear the input fields
    document.getElementById('name').value = '';
    document.getElementById('phone').value = '';

    // Add event listener to the delete button
    li.querySelector('.delete-btn').addEventListener('click', function () {
        li.remove(); // Remove the list item when delete button is clicked
    });
});*/

document.getElementById('addContactBtn').addEventListener('click', function () {
    // Get the input values
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;

    // Check if inputs are not empty
    if (name === '' || phone === '') {
        alert('Please enter both name and phone number');
        return;
    }

    // Check if the phone number is exactly 10 digits
    const phonePattern = /^\d{10}$/;
    if (!phonePattern.test(phone)) {
        alert('Please enter a valid 10-digit phone number');
        return;
    }

    // Create a new list item for the contact
    const li = document.createElement('li');
    li.innerHTML = `
        <span class="name">${name}</span> - <span class="phone">${phone}</span>
        <button class="delete-btn">Delete</button>
    `;

    // Add the new contact to the contact list
    document.getElementById('contactList').appendChild(li);

    // Clear the input fields
    document.getElementById('name').value = '';
    document.getElementById('phone').value = '';

    // Add event listener to the delete button
    li.querySelector('.delete-btn').addEventListener('click', function () {
        li.remove(); // Remove the list item when delete button is clicked
    });
});
