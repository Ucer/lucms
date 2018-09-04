<template>
<div>
  <div class="demo-upload-list" v-for="item in uploadList">
    <template v-if="item.status === 'finished'">
        <img :src="item.url">
        <div class="demo-upload-list-cover">
            <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
        </div>
    </template>
    <template v-else>
        <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
    </template>
  </div>
  <Upload ref="upload" :show-upload-list="false" :default-file-list="uploadConfig.default_list" :on-success="handleSuccess" :headers="uploadConfig.headers" :format="uploadConfig.format" :max-size="uploadConfig.max_size" :on-format-error="handleFormatError"
    :on-exceeded-size="handleMaxSize" :before-upload="handleBeforeUpload" :multiple="uploadConfig.multiple" :name="uploadConfig.file_name" type="drag" :action="uploadConfig.upload_url" style="display: inline-block;width:58px;">
    <div style="width: 58px;height:58px;line-height: 58px;">
      <Icon type="ios-camera" size="20"></Icon>
    </div>
  </Upload>
  <Collapse v-if="formatFileList.length > 0">
    <Panel name="1">
      预览
      <p slot="content">
        <img :src="item.url" :alt="item.name" v-for="(item,key) in formatFileList" />
      </p>
    </Panel>
  </Collapse>
</div>
</template>
<script>
import {
  deleteAttachment
} from '@/api/common'

export default {
  props: {
    isDelete: {
      type: Boolean,
      default: true
    },
    uploadConfig: {
      type: Object,
      default: {
        headers: {
          'Authorization': window.access_token
        },
        format: ['jpg', 'jpeg', 'png', 'gif'],
        max_size: 800, // 800KB
        upload_url: window.uploadUrl.uploadOther,
        file_name: 'tinymce',
        multiple: false,
        file_num: 0,
        default_list: [{
            name: '',
            attachment_id: 0,
            url: ''
          },
          {
            name: '',
            attachment_id: 0,
            url: ''
          }
        ]

      }
    }
  },
  data() {
    return {
      imgName: '',
      visible: false,
      uploadList: [],
      formatFileList: []
    }
  },
  methods: {
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList

      if (file.attachment_id > 0 && (this.isDelete === true)) {
        deleteAttachment(file.attachment_id).then(res => {
          this.$Notice.success({
            title: '操作成功',
            desc: '文件删除成功'
          })
        })
      }

      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1)

      let formatFileList = this.fomatFile()
      this.$emit('input', formatFileList)
      this.$emit('on-upload-change', this.uploadList, formatFileList)
    },
    handleSuccess(res, file) {
      file.url = res.data.url
      file.name = res.data.original_name
      file.attachment_id = res.data.attachment_id

      let formatFileList = this.fomatFile()
      this.$emit('input', formatFileList)
      this.$emit('on-upload-change', this.uploadList, formatFileList)
    },
    fomatFile() {
      let formatFileList = []
      this.uploadList.forEach(function(value, index, array) {
        formatFileList.push({
          attachment_id: value.attachment_id,
          url: value.url
        })
      })
      this.formatFileList = formatFileList

      if (this.uploadConfig.file_num === 1) {
        formatFileList = formatFileList[0]
      }
      return formatFileList
    },
    handleFormatError(file) {
      this.$Notice.warning({
        title: '文件格式不正确',
        desc: '文件 ' + file.name + ' 格式不正确。'
      })
    },
    handleMaxSize(file) {
      this.$Notice.warning({
        title: '超出文件大小限制',
        desc: '文件 ' + file.name + ' 太大，不能超过 ' + this.uploadConfig.max_size + 'kb'
      })
    },
    handleBeforeUpload() {
      const check = this.uploadList.length < this.uploadConfig.file_num
      if (!check) {

        this.$Notice.warning({
          title: '数量限制',
          desc: '最多只能上传' + this.uploadConfig.file_num + '个文件'
        })
      }
      return check
    }
  },
  mounted() {
    this.uploadList = this.$refs.upload.fileList

    let formatFileList = this.fomatFile()
    if (formatFileList != 'undefined') {
      this.$emit('input', formatFileList)
      this.$emit('on-upload-change', this.uploadList, formatFileList)
    }
  }
}
</script>
<style>
.demo-upload-list {
  display: inline-block;
  width: 60px;
  height: 60px;
  text-align: center;
  line-height: 60px;
  border: 1px solid transparent;
  border-radius: 4px;
  overflow: hidden;
  background: #fff;
  position: relative;
  box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
  margin-right: 4px;
}

.demo-upload-list img {
  width: 100%;
  height: 100%;
}

.demo-upload-list-cover {
  display: none;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, .6);
}

.demo-upload-list:hover .demo-upload-list-cover {
  display: block;
}

.demo-upload-list-cover i {
  color: #fff;
  font-size: 20px;
  cursor: pointer;
  margin: 0 2px;
}
</style>
