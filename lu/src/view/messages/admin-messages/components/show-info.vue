<template>
<div>
  <Drawer :closable="false" width="640" v-model="show" @on-close='closed' title="消息详情">
    <p class="drawer-title">基本资料：</p>
    <div class="drawer-profile">
      <Row>
        <Col span="12"> 消息标题： {{info.title}} </Col>
        <Col span="12" v-if="info.user"> 发送人：{{ info.user.name }} ({{ info.user.phone }}) </Col>
      </Row>
      <Divider/>
      <p class="drawer-title">消息内容：</p>
      <div v-html='info.content'> </div>
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

    }
  },
  methods: {
    closed() {
      this.show = false
      this.$emit('show-modal-close')
    }
  }
}
</script>
