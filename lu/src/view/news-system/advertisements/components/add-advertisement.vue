<template>
<div>
  <Modal v-model="modalShow" :closable='false' :mask-closable=false fullscreen>
    <p slot="header">添加广告</p>
    <Row>
      <Col span="16">
      <Form ref="formData" :model="formData" :rules="rules" label-position="left" :label-width="100">
        <FormItem label="广告标题" prop="name">
          <Input v-model="formData.name"></Input>
        </FormItem>
        <FormItem label="是否启用：">
          <RadioGroup v-model="formData.enable">
            <Radio label="F">禁用</Radio>
            <Radio label="T">启用</Radio>
          </RadioGroup>
        </FormItem>
      </Form>
      </Col>

      <Col span="8" class="padding-left-20">
      <Card>
        <p slot="title">
          <Icon type="paper-airplane"></Icon>
          其它信息
        </p>
        <Form label-position="right" :label-width="80">
          <FormItem label="广告位：">
            <Select v-model="formData.advertisement_positions_id" filterable @on-change="positionHasChanged" placeholder="请选择广告位">
              <Option v-for="(item,key) in advertisementPositionsIds" :value="item.id" :key="key">{{ item.name }} </Option>
            </Select>
          </FormItem>
          <FormItem label="链接地址：">
            <Input v-model="formData.link_url" placeholder="请输入链接地址如： http://lucms.com"></Input>
          </FormItem>
          <FormItem label="排序：">
            <Input v-model="formData.weight" placeholder="请输入序号"></Input>
          </FormItem>
          <FormItem label="有效期：">
            <DatePicker type="datetimerange" placement="bottom-end" placeholder="请选择有效期，不选永久有效" confirm @on-clear="timeClear" @on-change="timeChanged" style="width:100%"></DatePicker>
          </FormItem>
        </Form>
      </Card>
      </Col>
    </Row>

    <div slot="footer">
      <Button type="text" @click="cancel">取消</Button>
      <Button type="primary" @click="addAdvertisementExcute" :loading='saveLoading'>保存 </Button>
    </div>
  </Modal>
</div>
</template>
<script>
import {
  addAdvertisement
} from '@/api/advertisement'

export default {
  props: {
    advertisementPositionsIds: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      modalShow: true,
      saveLoading: false,
      formData: {
        name: '',
        enable: 'F',
        advertisement_positions_id: 0,
        advertisement_positions_type: '',
        model_column_value: {
          model: '',
          column: '',
          value: '',
        },
        link_url: '',
        start_at: '',
        end_at: '',
        weight: 20,

      },
      rules: {
        name: [{
          required: true,
          message: '请填写广告标题',
          trigger: 'blur'
        }],
      },
    }
  },
  methods: {
    addAdvertisementExcute() {
      let t = this
      t.saveLoading = true
      t.$refs.formData.validate((valid) => {
        if (valid) {
          addAdvertisement(t.formData).then(res => {
            t.saveLoading = false
            t.modalShow = false
            t.$emit('on-add-modal-success')
            t.$emit('on-add-modal-hide')
            t.$Notice.success({
              title: res.message
            })
          }, function(error) {
            t.saveLoading = false;
          })
        }
      })
    },
    positionHasChanged() {
      let t = this;
      var key = t.formData.advertisement_positions_id;
      t.formData.advertisement_positions_type = t.advertisementPositionsIds[key].type;
    },
    timeChanged: function(value, date_type) {
      let t = this;
      t.formData.start_at = value[0];
      t.formData.end_at = value[1];
    },
    timeClear() {
      let t = this;
      t.formData.start_at = '';
      t.formData.end_at = '';
    },
    cancel() {
      this.$emit('on-add-modal-hide')
      this.modalShow = false
    }
  }
}
</script>
