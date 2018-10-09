<template>
<div>
  <Drawer :closable="false" width="640" v-model="show" @on-close='closed' title="用户信息：">
    <p class="drawer-title">基本资料：</p>
    <div class="drawer-profile">
      <Row>
        <Col span="12"> Slug: {{info.slug}} </Col>
        <Col span="12"> 作者： {{info.user.name}} </Col>
        <Col span="12"> 访问方式：
        <span class="green-color" v-if="info.access_type === 'PUB' "> 公开  </span>
        <span class="green-color" v-else-if="info.access_type === 'PWD' ">  密码访问： {{ info.access_value }}  </span>
        <span class="green-color" v-else>  私密  </span>
        </Col>
      </Row>
    </div>
  </Drawer>
</div>
</template>
<script>
export default {
  props: {
    info: {
      type: Object,
      default: ''
    }
  },
  data() {
    return {
      show: true,
      agreement: '',
      spinLoading: true
    }
  },
  created() {},
  methods: {
    closed() {
      this.show = false
      this.$emit('show-modal-close')
    }
  }
}
</script>
