<template>
<div>
  <Modal v-model="modalShow" :closable='false' :mask-closable=false width="600">
    <p slot="header">编辑权限</p>
    <Form ref="formData" :model="formData" :rules="rules" label-position="left" :label-width="100">
      <FormItem label="权限名称" prop="name">
        <Input v-model="formData.name" placeholder="请输入权限名称"></Input>
      </FormItem>
      <FormItem label="看守器" prop="guard_name">
        <Input v-model="formData.guard_name" placeholder="请输入看守器"></Input>
      </FormItem>
      <FormItem label="权限描述" prop="description">
        <Input v-model="formData.description" placeholder="请输入权限描述"></Input>
      </FormItem>
    </Form>
    <div slot="footer">
      <Button type="text" @click="cancel">取消</Button>
      <Button type="primary" @click="addEditPermissionExcute" :loading='saveLoading'>保存 </Button>
    </div>
    <div class="demo-spin-container" v-if='spinLoading === true'>
      <Spin fix>
        <Icon type="load-c" size=18 class="spin-icon-load"></Icon>
        <div>加载中...</div>
      </Spin>
    </div>
  </Modal>
</div>
</template>
<script>
import {
  addEditPermission,
  getPermissionInfoById
} from '@/api/permissions'

export default {
  props: {
    modalId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      modalShow: true,
      saveLoading: false,
      formData: {
        name: '',
        guard_name: '',
        description: '',
      },
      rules: {
        name: [{
          required: true,
          message: '请填写权限名称',
          trigger: 'blur'
        }],
        guard_name: [{
          required: true,
          message: '请填写看守器',
          trigger: 'blur'
        }],
      },
    }
  },
  created() {
    if (this.modalId > 0) {
      this.getPermissionInfoByIdExcute()
    }
    this.spinLoading = true
  },
  methods: {
    getPermissionInfoByIdExcute() {
      let t = this;
      t.spinLoading = true;
      getPermissionInfoById(t.modalId).then(res => {
        let res_data = res.data
        t.formData = {
          id: res_data.id,
          name: res_data.name,
          guard_name: res_data.guard_name,
          description: res_data.description
        }
        t.spinLoading = false;
      })

    },
    addEditPermissionExcute() {
      let t = this
      t.$refs.formData.validate((valid) => {
        if (valid) {
          t.saveLoading = true
          addEditPermission(t.formData).then(res => {
            t.saveLoading = false
            t.modalShow = false
            t.$emit('on-edit-modal-success')
            t.$emit('on-edit-modal-hide')
            t.$Notice.success({
              title: res.message
            })
          }, function(error) {
            t.saveLoading = false;
          })
        }
      })
    },
    cancel() {
      this.modalShow = false
      this.$emit('on-edit-modal-hide')
    }
  }
}
</script>
