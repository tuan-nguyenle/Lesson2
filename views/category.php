<?php

use app\core\Application;

if (isset($_GET['search'])) {
    $allData = Application::$coreApp->categoryService->getCategoriesWithSearch($_GET['search']);
    $total = Application::$coreApp->categoryService->getAllWithSearch($_GET['search']);
} else {
    $allData = Application::$coreApp->categoryService->getCategories();
    $total = Application::$coreApp->categoryService->getAll();
}

?>
<main class="container mt-3 pl-5 pr-5">
    <form method="get">
        <div class="row ml-4 pl-4 pr-4 mt-4 mb-4">
            <input type="search" style="width: 100%;" class="form-control" id="searchInput" name="search">
            <button type="submit" style="display:none;"></button>
        </div>
    </form>
    <div class="d-flex justify-content-between align-items-center pl-5 pr-4 pb-4">
        <p id="resultFounded">Search found <?= sizeof($total) ?> result</p>
        <span>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-primary btn-circle" data-toggle="modal" data-target="#staticBackdrop" style="border-radius: 35px;">
                <i class="fa fa-plus fa-1x" aria-hidden="true"></i>
            </button>
        </span>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add new category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="txtCategoryName">Category Name</label>
                            <input type="text" class="form-control" name="txtCategoryName" id="txtCategoryName" aria-describedby="txtCategoryHelp" placeholder="">
                            <small id="txtCategoryHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label class="my-1 mr-2" for="cbParentCategory">Parent category</label>
                            <select class="custom-select my-1 mr-sm-2" name="cbParentCategory" id="cbParentCategory" style="width: 75%;">
                                <?php
                                foreach ($total as $key => $value) {
                                    echo '<option value="' . $value['id'] . '">' . "Option " . $value['id'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table pb-4 ml-5" style="width: 95%;" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function buildCategoryList($categories, $indent = 0)
            {
                $html = "";
                $symbol = "";
                if ($indent > 0) {
                    $symbol = "L ";
                }
                foreach ($categories as $category) {
                    $html .= '<tr>';
                    $html .= '<td>' . $category['id'] . '</td>';
                    $html .= '<td class="nameCategory" style="padding-left:' . ($indent * 20) . 'px;" id="cell' . $category['id'] . '">';
                    $html .= $symbol . $category['name'] . '</td>';
                    $html .= '<td><button style="border: none;" data-toggle="modal" data-target="#updateForm"  onclick="handleUpdate(' . $category['id'] . ')">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    $html .= '<button style="border: none;" onclick="copyToClipboard(cell' . $category['id'] . ')"><i class="fa fa-files-o" aria-hidden="true"></i></button>';
                    $html .= '<button style="border: none;" onclick="deleteCategory(' . $category['id'] . ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                        . '</td>';
                    $html .= '</tr>';
                    if (!empty($category['children'])) {
                        $html .= buildCategoryList($category['children'], $indent + 1);
                    }
                }
                return $html;
            }
            echo buildCategoryList($allData);
            ?>
        </tbody>

    </table>
    <div class="modal fade" id="updateForm" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateFormLabel">Update Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txtCategoryNameUpdate">Category Name</label>
                        <input type="hidden" id="idCategory" value=" ">
                        <input type="text" class="form-control" name="txtCategoryNameUpdate" id="txtCategoryNameUpdate" aria-describedby="txtCategoryHelp" placeholder="" value="text">
                        <small id="txtCategoryHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label class="my-1 mr-2" for="cbParentCategory">Parent category</label>
                        <select class="custom-select my-1 mr-sm-2" name="cbParentCategory" id="cbParentCategoryUpdate" style="width: 75%;">
                            <?php
                            foreach ($total as $key => $value) {
                                echo '<option value="' . $value['id'] . '">' . "Option " . $value['id'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            info: false,
            "lengthChange": false
        });
    });

    function handleUpdate(id) {
        $.ajax({
            type: "post",
            data: {
                id: id,
            },
            url: "http://localhost:8080/category",
        }).done(function(data) {
            let obj = JSON.parse(data);
            console.log(data);
            document.getElementById("idCategory").value = obj.id;
            document.getElementById("txtCategoryNameUpdate").value = obj.name;
            document.getElementById("cbParentCategoryUpdate").value = obj.parentID;
        });
    }

    function deleteCategory(id) {
        $.ajax({
            type: "post",
            data: {
                id: id,
            },
            url: "http://localhost:8080/delete",
        }).done(function(data) {
            console.log(data);
            alert("Xóa thành công");
        });
    }

    $("#txtCategoryNameUpdate").on("change", function(e) {
        $.ajax({
            type: "post",
            data: {
                name: document.getElementById("txtCategoryNameUpdate").value,
                id: document.getElementById("idCategory").value,
            },
            url: "http://localhost:8080/update",
        }).done(function(data) {
            alert("Update thành công");
            window.location.href = "http://localhost:8080";
        });
    })

    $("#cbParentCategoryUpdate").on("change", function(e) {
        $.ajax({
            type: "post",
            data: {
                parentID: document.getElementById("cbParentCategoryUpdate").value,
                id: document.getElementById("idCategory").value,
            },
            url: "http://localhost:8080/update",
        }).done(function(data) {
            alert("Update thành công");
            window.location.href = "http://localhost:8080";
        });
    })

    function copyToClipboard(cell) {
        // Copy the text inside the text field
        navigator.clipboard.writeText(cell.innerText);
        // Alert the copied text
        alert("Copied the text: " + cell.innerText);
    }
</script>