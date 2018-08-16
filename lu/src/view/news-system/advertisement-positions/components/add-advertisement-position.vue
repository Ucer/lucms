<template>
<div>

  <Modal v-model="modalShow" :closable='false' :mask-closable=false :width="500">
    <h3 slot="header" style="color:#2D8CF0">添加广告位</h3>
    <Form ref="formData" :model="formData" :label-width="100" label-position="right" :rules="rules">
      <FormItem label="广告位名称" prop="name">
        <Input v-model="formData.name" placeholder="请输入广告位名称"></Input>
      </FormItem>
      <FormItem label="广告位类型" prop="type">
        <Select v-model="formData.type" filterable>
            <Option v-for="(item,key) in tableStatus.type" :value="key" :key="key">{{ item }}</Option>
        </Select>
      </FormItem>
      <FormItem label="广告位描述" prop="description">
        <Input type="textarea" v-model="formData.description" placeholder="请输入描述"></Input>
      </FormItem>

    </Form>
    <div slot="footer">
      <Button type="text" @click="cancel">取消</Button>
      <Button type="primary" @click="addAdvertisementPositionExcute" :loading="saveLoading"> 保存 </Button>
    </div>
  </Modal>
</div>
</template>

<script>
export default {
  props: {
    tableStatus
  },
  data() {
    return {
      // modalShow: true,
      // saveLoading: false,
      // formData: {
      //   name: '',
      //   type: '',
      //   description: '',
      // },
      // rules: {
      //   name: [{
      //     required: true,
      //     message: '请填写广告位名称',
      //     trigger: 'blur'
      //   }],
      //   type: [{
      //     required: true,
      //     message: '请选择类型',
      //     trigger: 'blur'
      //   }],
      // },
    }
  }
}
</script>
