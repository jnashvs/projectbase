<template>
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <ol class="breadcrumb float-sm-right float-md-right">
        <li v-if="breadcrumbTittle" class="breadcrumb-item">
          <a href="home">Home</a>
        </li>
        <li v-else class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">{{ breadcrumbTittle }}</li>
      </ol>
    </div>
  </div>
</template>

<script>
export default {
  name: "page-adress",
  props: ["breadcrumbTittle"],
  data: () => ({
    titulo: "adress"
  }),
  mounted() {
    
  }
};
</script>