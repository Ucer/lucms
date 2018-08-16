<template>
<div>
  <Modal v-model="modalShow" :closable='false' :mask-closable=false width="600">
    <p slot="title">添加用户</p>
    <Form ref="formData" :model="formData" :rules="rules" label-position="left" :label-width="100">
      <FormItem label="昵称：" prop="name">
        <Input v-model="formData.name"></Input>
      </FormItem>
      <FormItem label="邮箱：">
        <Input v-model="formData.email"></Input>
      </FormItem>
      <FormItem label="登录密码：" prop="password">
        <Input type="password" v-model="formData.password"></Input>
      </FormItem>
      <FormItem label="登录密码确认：" prop="password_confirmation">
        <Input type="password" v-model="formData.password_confirmation"></Input>
      </FormItem>
      <FormItem label="可登录后台：">
        <RadioGroup v-model="formData.is_admin">
          <Radio label="F">否</Radio>
          <Radio label="T">是</Radio>
        </RadioGroup>
      </FormItem>
      <FormItem label="头像：">
        <div style="display:inline-block;width:50%">
          <Upload :show-upload-list="false" :on-success="handleSuccess" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :headers="uploadConfig.headers" :max-size="uploadConfig.max_size" :format="uploadConfig.format" name="avatar" type="drag"
            :action="uploadConfig.uploadUrl" style="display: inline-block;width:58px;">
            <div style="width: 58px;height:58px;line-height: 58px;">
              <Icon type="camera" size="20"></Icon>
            </div>
          </Upload>
          <img class="head_image" :src="formData.head_image.url" alt="" v-if="formData.head_image.url">
        </div>
      </FormItem>
    </Form>
    <div slot="footer">
      <Button type="text" @click="cancel">取消</Button>
      <Button type="primary" @click="addUserExcute" :loading='saveLoading'>保存 </Button>
    </div>
  </Modal>
</div>
</template>
<script>
import {
  addUser
} from '@/api/user'

export default {
  data() {
    const validatePassword = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入登录密码'))
      } else {
        if (this.formData.password !== '') {
          // 对第二个密码框单独验证
          this.$refs.formData.validateField('password_confirmation')
        }
        callback()
      }
    }
    const validatePasswordConfirm = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入确认密码'))
      } else if (value !== this.formData.password) {
        callback(new Error('两次密码不一致 '))
      } else {
        callback()
      }
    }
    return {
      modalShow: true,
      saveLoading: false,
      formData: {
        name: '',
        email: '',
        is_admin: 'F',
        password: '',
        password_confirmation: '',
        head_image: {
          attachment_id: 0,
          url: '',
        },
      },
      uploadConfig: {
        headers: {
          'Authorization': window.access_token
        },
        format: ['jpg', 'jpeg', 'png'],
        max_size: 500,
        uploadUrl: window.uploadUrl.uploadAvatar
      },
      rules: {
        name: [{
            required: true,
            message: '请填写昵称',
            trigger: 'blur'
          },
          {
            type: 'string',
            min: 2,
            message: '昵称至少要 2 个字符',
            trigger: 'blur'
          }
        ],
        email: [{
            required: true,
            message: '请填写邮箱',
            trigger: 'blur'
          },
          {
            type: 'email',
            message: '邮箱格式不正确',
            trigger: 'blur'
          },
        ],
        password: [{
          validator: validatePassword,
          trigger: 'blur'
        }],
        password_confirmation: [{
          validator: validatePasswordConfirm,
          trigger: 'blur'
        }],
      },
    }
  },
  methods: {
    addUserExcute() {
      let t = this;
      t.saveLoading = true
      t.$refs.formData.validate((valid) => {
        if (valid) {
          addUser(t.formData).then(res => {
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
        } else {
          t.saveLoading = false
        }
      })
    },
    cancel() {
      this.modalShow = false
      this.$emit('on-add-modal-hide')
    },
    handleSuccess(res, file) {
      file.url = res.data.url;
      file.name = res.data.original_name;
      this.formData.head_image.attachment_id = res.data.attachment_id;
      this.formData.head_image.url = res.data.url;
    },
    handleFormatError(file) {
      this.$Notice.warning({
        title: '文件格式不正确',
        desc: '文件 ' + file.name + ' 格式不正确，请上传 jpg 或 png 格式的图片。'
      });
    },
    handleMaxSize(file) {
      this.$Notice.warning({
        title: '超出文件大小限制',
        desc: '文件 ' + file.name + ' 太大，不能超过 ' + this.uploadConfig.max_size + 'kb'
      });
    },
  }
}
</script>
