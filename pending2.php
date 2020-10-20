<?php include 'header.php' ?>

<div id="pending-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">CustomerID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Name of Pharmacy</th>
                <th scope="col">NPI#</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="empty-msg d-none">
                <td colspan="7">There are no pending accounts!</td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'footer.php' ?>