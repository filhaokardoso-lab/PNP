@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

@if (session('sucess'))
<script>
    document.addEventListener('DOMContentLoaded', ()=> {
    Swal.fire({
    title: "Pronto!",
    text: "{{ session('sucess') }}",
    icon: "success"
    });
});
</script>
@endif
