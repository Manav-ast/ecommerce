/**
 * Category Form Handling
 * 
 * This file contains functions for handling category form submissions
 * and displaying notifications using SweetAlert2.
 */

$(document).ready(function () {
    // Auto-generate slug from category name
    $('#category_name').on('input', function () {
        let slug = $(this).val().toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]+/g, '');
        $('#category_slug').val(slug);
    });

    // Show Image Preview
    $('#category_image').on('change', function () {
        let file = this.files[0];

        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#image_preview').attr('src', e.target.result).removeClass('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Clear validation errors when input changes
    $('input, textarea').on('input change', function () {
        let errorId = 'error-' + $(this).attr('name');
        $('#' + errorId).addClass('hidden');
    });

    // jQuery Validation
    $("#addCategoryForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            },
            slug: {
                required: true,
                maxlength: 255
            },
            description: {
                maxlength: 500
            },
            image: {
                required: true,
                extension: "jpeg|jpg|png|gif"
            }
        },
        messages: {
            name: {
                required: "Please enter a category name",
                maxlength: "Category name cannot exceed 255 characters"
            },
            slug: {
                required: "Slug is required",
                maxlength: "Slug cannot exceed 255 characters"
            },
            description: {
                maxlength: "Description cannot exceed 500 characters"
            },
            image: {
                required: "Please select an image",
                extension: "Please select a valid image file (jpeg, jpg, png, gif)"
            }
        },
        errorPlacement: function (error, element) {
            // Custom error placement - use existing error spans
            let name = element.attr("name");
            $("#error-" + name).html(error.text()).removeClass('hidden');
        },
        submitHandler: function (form) {
            // AJAX Form Submission using jQuery
            let formData = new FormData(form);

            $.ajax({
                url: $(form).data('action'),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.success) {
                        // Show success toast notification
                        if (typeof showSuccessToast === 'function') {
                            showSuccessToast(data.message);
                        } else {
                            alert(data.message); // Fallback if function not available
                        }

                        // Reset form after success
                        setTimeout(function () {
                            window.location.href = $(form).data('redirect');
                        }, 1000);
                    } else if (data.errors) {
                        // Show validation errors
                        $.each(data.errors, function (key, value) {
                            $('#error-' + key).text(value[0]).removeClass('hidden');
                        });
                    } else {
                        // Show error toast notification
                        if (typeof showErrorToast === 'function') {
                            showErrorToast(data.message || 'An error occurred while adding the category.');
                        } else {
                            alert(data.message || 'An error occurred while adding the category.'); // Fallback
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    // Show error toast notification
                    if (typeof showErrorToast === 'function') {
                        showErrorToast('An error occurred while processing your request.');
                    } else {
                        alert('An error occurred while processing your request.'); // Fallback
                    }
                }
            });
        }
    });

    // Add additional method for file extension validation
    $.validator.addMethod("extension", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp("\\.(?:" + param + ")$", "i"));
    }, "Please select a valid file with the correct extension.");
});