<template>
<div>
  <Modal v-model="modalShow" :closable='false' :mask-closable=false width="600">
    <p slot="header">修改分类</p>
    <Form ref="formData" :model="formData" :rules="rules" label-position="left" :label-width="100">
      <FormItem label="标签名称" prop="name">
        <Input v-model="formData.name" placeholder="请输标签名称"></Input>
      </FormItem>

    </Form>
    <div slot="footer">
      <Button type="text" @click="cancel">取消</Button>
      <Button type="primary" @click="addEditTagExcute" :loading='saveLoading'>保存 </Button>
    </div>
  </Modal>
</div>
</template>
<script>
import {
  addEditTag,
  getTagInfoById,
} from '@/api/tag'

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
      formdataFinished: false,
      formData: {
        id: 0,
        name: '',
      },
      rules: {
        name: [{
          required: true,
          message: '请填写标签名称',
          trigger: 'blur'
        }],
      }
    }
  },
  mounted() {
    if (this.modalId > 0) {
      this.getTagInfoByIdExcute()
    }
  },
  methods: {
    getTagInfoByIdExcute() {
      let t = this;
      getTagInfoById(t.modalId).then(res => {
        let res_data = res.data
        t.formData = {
          id: res_data.id,
          name: res_data.name
        }
        t.formdataFinished = true
        t.spinLoading = false
      })
    },
    addEditTagExcute() {
      let t = this
      t.$refs.formData.validate((valid) => {
        if (valid) {
          t.saveLoading = true
          addEditTag(t.formData).then(res => {
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
    },
  }
}
</script>
