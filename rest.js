const tableElement = document.getElementById('table');
const userElement = document.getElementById('user');

let f = getAllUsers();

async function getAllUsers() {
    const url = '/users';
    let response = await fetch(url);
    let users = await response.json();

    if (users.length > 0) {
        tableElement.hidden = false;
        userElement.hidden = true;

        const usersElement = document.getElementById('users');
        usersElement.innerHTML = '';
        users.forEach(function (user) {
            usersElement.innerHTML += `
            <tr>
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.role}</td>
                <td>
                    <button type="button" onclick="getUser(${user.id})">More</button>
                </td>
            </tr>
            `;
        });
    }
}

async function getUser(id) {
    const url = `/users/${id}`;
    let response = await fetch(url);
    let user = await response.json();

    tableElement.hidden = true;
    userElement.hidden = false;

    console.log(user);

    userElement.innerHTML = `
    <form>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="${user.name}">
        
        <label for="rolee">Role</label>
        <input type="text" id="role" name="role" value="${user.role}">
        
        <button type="button" onclick="getAllUsers()">Back to users</button>
    </form>
    `;
}