$("select[name=parent_id]").select2({
  language: { noResults: () => "نتیجه ای یافت نشد" },
});

// CKEditor
CKEDITOR.replace("ckeditor", {
  language: "fa",
});
