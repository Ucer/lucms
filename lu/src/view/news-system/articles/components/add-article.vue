<template>
<div>
  <Modal v-model="modalShow" :closable='false' :mask-closable=false fullscreen>
    <p slot="header">添加分类</p>
    <Row>
      <Col span="16">
      <Form ref="formData" :model="formData" :rules="rules" label-position="left" :label-width="100">
        <FormItem label="标题：" prop="title">
          <Input v-model="formData.title"></Input>
        </FormItem>
        <FormItem label="封面：">
          <upload v-model="formData.cover_image" :upload-config="imguploadConfig" @on-upload-change='uploadChange'></upload>
        </FormItem>
        <FormItem label="是否启用：">
          <RadioGroup v-model="formData.enable">
            <Radio label="F">禁用</Radio>
            <Radio label="T">启用</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="关键词：" prop="keywords">
          <Input type="textarea" v-model="formData.keywords" placeholder="以英文逗号隔开"></Input>
          <input-helper text="以英文逗号隔开"></input-helper>
        </FormItem>
        <FormItem label="描述：" prop="description">
          <Input type="textarea" v-model="formData.description" placeholder="请输入描述"></Input>
        </FormItem>
        <FormItem label="文章内容：">
          <textarea id="addArticleEditor"></textarea>
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
          <FormItem label="分类：">
            <Select v-model="formData.category_id" filterable placeholder="请选择文章分类">
                <Option v-for="(item,key) in articleCategories" :value="item.id" :key="key">{{ item.name }} </Option>
            </Select>
          </FormItem>
          <FormItem label="排序：">
            <Input v-model="formData.weight" placeholder="请输入序号"></Input>
          </FormItem>
        </Form>
      </Card>
      </Col>
    </Row>
    <div slot="footer">
      <Button type="text" @click="cancel">取消</Button>
      <Button type="primary" @click="addArticleExcute" :loading='saveLoading'>保存 </Button>
    </div>
  </Modal>
</div>
</template>
<script>
import {
  addArticleExcute
} from '@/api/article'

import Upload from '_c/common/upload'
import InputHelper from '_c/common/input-helper'
export default {
  components: {
    Upload,
    InputHelper
  },
  props: {
    articleCategories: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      modalShow: true,
      saveLoading: false,
      formData: {
        tags: 0,
        content: '',
        category_id: 0,
        enable: 'F',
        weight: 20,
        recommend: 'F',
        top: 'F',
        cover_image: {
          attachment_id: 0,
          url: '',
        },
      },
      rules: {
        name: [{
          required: true,
          message: '请填写分类名称',
          trigger: 'blur'
        }],
      },
      imguploadConfig: {
        headers: {
          'Authorization': window.access_token
        },
        format: ['jpg', 'jpeg', 'png', 'gif'],
        max_size: 800, // 800KB
        upload_url: window.uploadUrl.uploadOther,
        file_name: 'other',
        multiple: false,
        file_num: 1,
        default_list: []
      },
    }
  },
  methods: {
    addArticleExcute() {
      let t = this
      t.$refs.formData.validate((valid) => {
        if (valid) {
          t.saveLoading = true
          addArticle(t.formData).then(res => {
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
    cancel() {
      this.modalShow = false
      this.$emit('on-add-modal-hide')
    },
    uploadChange(fileList, formatFileList) {}
  }
}
</script>
