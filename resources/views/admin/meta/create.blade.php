@extends('admin.layout')

@section('content')

<page-meta inline-template>
	<div>
	    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
					<h1 class="h2">Meta</h1>
					<a class="btn btn-sm btn-outline-secondary" href="/admin/pages/edit/{{ $page->id }}">Back</a>
	    </div>   

    	<div class="filter-bar">
				<ul class="filters float-right">
					<li>
						<button class="btn btn-outline-secondary" @click="addMeta" v-if="!metaSelectionMode" v-cloak>Add Repeater</button>
					</li>

					<li>
						<select v-if="metaSelectionMode" @change="selectMetaType($event)" class="form-control" v-cloak>
									<option value="">Select</option>
									<option value="slider">Slider</option>
									<option value="text">Text</option>
									<option value="dropdown">Dropdown</option>
								</select>
					</li>
				</ul>
			</div>

        <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
        	<input type="hidden" name="page_id" id="page_id" value="{{ $page->id }}">
            @csrf

            @if ( ! empty($page))
                <div class="form-group">
                    <label for="page">Page</label>
                    @include('admin.partials.field-error', ['field' => 'page'])
                    <input class="form-control" type="text" name="page" value="{{ $page->title }}" disabled>
                </div>
            @endif
			

			<!--=======================================
			=            Main image upload            =
			========================================-->
			<div class="card mb-3">
				<div class="card-header">
					<label>Main Image</label>
				</div>
				<div class="card-body">
					<div v-if="image.uploaded" v-cloak>
						<input name="main_image[uploaded]" id="main_image[uploaded]" type="hidden" :value="image.uploaded">
						<img :src="image.uploaded" style="width:100px;" />
						<button class="btn btn-danger float-right" type="button" @click="image.uploaded=null">Remove Image</button>
					</div>

		            <div class="form-group" v-show="!image.uploaded" v-cloak>
						<input id="main_image[input]" name="main_image[input]" type="file" class="file" id="image_meta" data-show-preview="false" data-show-upload="false">
					</div>
				</div>
			</div>
			

			<!--=======================================
			=            Main Content           =
			========================================-->
			<div class="card mb-3">
				<div class="card-header">
					<label>Content</label>
				</div>
				<div class="card-body">
					<textarea name="content" id="content" cols="100" rows="10" v-model="content"></textarea>
				</div>
			</div>


			<!--================================================
			=            Repeater for text inputs              =
			=================================================-->
            <div class="card mb-3" v-for="(rblock,index) in repeater.text" v-if="repeater.text.length>0" :key="'text_'+rblock.id" v-cloak>
				<div class="card-header">
					<div class="form-group">
						<label>Text Repeater</label>
						<div class="input-group">
							<input type="text" :name="rblock.name+'_name'" class="form-control" v-model="rblock.name" required />
							<div class="input-group-append">
						    	<button class="btn btn-danger" type="button" @click="removeRepeaterBlock('text',index)">Remove Repeater</button>
						  	</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group" v-for="(txt,innerIndex) in rblock.inputs" :key="innerIndex">

						<div class="input-group mb-3">
						  <input class="form-control" required type="text" :name="'repeaters[text]['+rblock.name+']['+innerIndex+'][value]'" v-model="txt.value"  />
						  <div class="input-group-append">
						    <button class="btn btn-danger" type="button" @click="removeFromARepeater(index,'text',innerIndex)">Remove Field</button>
						  </div>
						</div>

					</div>
					<button class="btn btn-outline-secondary btn-sm" type="button" @click="addToRepeater(index,'text')">Add text field</button>	
				</div>
			</div>

			
			<!--================================================
			=            Repeater for dropdown type            =
			=================================================-->
			<div class="card mb-3" v-for="(rblock,index) in repeater.dropdown" v-if="repeater.dropdown.length>0" :key="'dropdown_'+rblock.id" v-cloak>

				<div class="card-header">
					<div class="form-group">
						<label>Dropdown Repeater</label>
						<div class="input-group">
							<input type="text" :name="rblock.name+'_name'" class="form-control" v-model="rblock.name" required />
							<div class="input-group-append">
						    	<button class="btn btn-danger" type="button" @click="removeRepeaterBlock('dropdown',index)">Remove Repeater</button>
						  	</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group" v-for="(pair,innerIndex) in rblock.inputs" :key="innerIndex">

						<div class="input-group mb-3">
						  <input class="form-control" required type="text" :name="'repeaters[dropdown]['+rblock.name+']['+innerIndex+'][key]'" v-model="pair.key"  />
						  <input class="form-control" required type="text" :name="'repeaters[dropdown]['+rblock.name+']['+innerIndex+'][value]'" v-model="pair.value"  />
						  <div class="input-group-append">
						    <button class="btn btn-danger" type="button" @click="removeFromARepeater(index,'dropdown',innerIndex)">Remove Pair</button>
						  </div>
						</div>

					</div>
					<button class="btn btn-outline-secondary btn-sm" type="button" @click="addToRepeater(index,'dropdown')">Add dropdown pair</button>	
				</div>
			</div>

			<!--================================================
			=           Repeater for images (slider)           =
			=================================================-->
			<div class="card mb-3" v-for="(rblock,index) in repeater.slider" v-if="repeater.slider.length>0" :key="'slider_'+rblock.id" v-cloak>

				<div class="card-header">
					<div class="form-group">
						<label>Images Repeater (Slider)</label>
						<div class="input-group">
							<input type="text" :name="rblock.name+'_name'" class="form-control" v-model="rblock.name" required />
							<div class="input-group-append">
						    	<button class="btn btn-danger" type="button" @click="removeRepeaterBlock('slider',index)">Remove Repeater</button>
						  	</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group" v-for="(image,innerIndex) in rblock.inputs" :key="innerIndex">
						
						<div v-if="image.uploaded" v-cloak>
							<input :name="'repeaters[slider]['+rblock.name+']['+innerIndex+'][uploaded]'" :name="'repeaters[slider]['+rblock.name+']['+innerIndex+'][uploaded]'" type="hidden" :value="image.uploaded">
							<img :src="image.uploaded" style="width:100px;" />
							<button class="btn btn-danger float-right" type="button" @click="image.uploaded=null">Remove Image</button>
						</div>

						<div class="input-group mb-3" v-if="!image.uploaded" v-cloak>
							<div class="input-group-prepend">
								<span class="input-group-text">Upload</span>
							</div>
							<div class="custom-file">
								<input type="file" class="custom-file-input" :name="'repeaters[slider]['+rblock.name+']['+innerIndex+'][input]'" required>
								<label class="custom-file-label">Choose file</label>
							</div>

							<div class="input-group-append">
						    	<button class="btn btn-danger" type="button" @click="removeFromARepeater(index,'slider',innerIndex)">Remove image</button>
						  	</div>
						</div>

					</div>
					<button class="btn btn-outline-secondary btn-sm" type="button" @click="addToRepeater(index,'slider')">Add Image</button>	
				</div>
			</div>

            <input type="submit" class="btn btn-sm btn-outline-secondary" value="Save">
        </form>
	</div>


</page-meta>	

	
@endsection
