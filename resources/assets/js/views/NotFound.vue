<template>
	<div class="section">
        <div class="not__found">
            <h1>404 Page Not Found!</h1>
            <p>Sorry, the page you are looking for could not be found.</p>
        </div>   
    </div>
</template>
<script>
    export default {
        mounted() {
            Event.fire('page-loaded', 'page-index');
        }
    }
</script>