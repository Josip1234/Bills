<?php 
class Validation{
    const SHOP_ALREADY_EXISTS="<p class='text-danger'>Shop already exists. Please enter different one.</p>";
    const SUCCESS_UPDATE="<p class='text-success'>Successfully updated record in database</p>";
    const UPDATE_FAIL="<p class='text-danger'>Update failed.</p>";
    const SUCCESSFULL_INSERT="<p class='text-success'>Successfully inserted new record.</p>";
    const INVALID="<p class='text-danger'>Invalid value.</p>";
    const INSERT_FAILED="<p class='text-danger'>Adding new record to database has failed.</p>";
    const EMPTY_RECORD="Error!!! The record you wanted to insert is empty. Please, enter non-empty entry.";
    const FAILED_VALIDATION="<p class='text-danger'>Validation has failed. Please, enter different values.</p>";
    const DELETE_CONFIRMATION = "Are you sure do you want to delete data with id number ";
    const SUCCESSFULL_DELETION="<p class='text-success'>Successfully deleted record in database</p>";
}

?>