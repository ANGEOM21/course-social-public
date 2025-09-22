<script>
    const notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        },
    });
    notyf.open({
        type: "{{ $type }}",
        message: "{{ $message }}"
    });
</script>
