
<div class="row justify-content-center">

    <div class="col-md-9 col-lg-9 col-sm-9">

        <div class="col-md-9 col-lg-9 col-sm-9 offset-sm-3" style="background: white; padding: 10px; margin: 10px;">

            <form method="post" action="{{ route('companies.store') }}">

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="company-name">Name <span class="required">*</span> </label>
                    <input placeholder="Enter the name" class="form-control" id="company-name" required name="name" spellcheck="false" />
                </div>

                <div class="form-group">
                    <label for="company-description">Description </label>
                    <textarea placeholder="Enter the description" style="resize: vertcical" id="company-content" rows="5" spellcheck="false" class="form-control autosize-target text-left" name="description" spellcheck="false">
                    </textarea>
                </div>

                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Submit" />

                </div>

            </form>

        </div>

    </div>

</div>