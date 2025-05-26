
<x-layout>
    <x-slot name='title'>  Edit Job Listing </x-slot>
    <div
    class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl"
>
    <h2 class="text-4xl text-center font-bold mb-4">
        Edit Job Listing
    </h2>
    <form
        method="POST"
        action="{{ route('jobs.update',$job->id)}}"
        enctype="multipart/form-data"
    >
    @csrf
    @method('PUT')
        <h2
            class="text-2xl font-bold mb-6 text-center text-gray-500"
        >
            Job Info
        </h2>

        <x-inputs.text id="title" name="title" label="Job Title" placeholder="Softwate Engineer" :value="old('title',$job->title)" />

        <x-inputs.text-area id="description" name="description" label="Description" placeholder="We are seeking a skiled and motivated Software Developer.." :value="old('description',$job->description)"   />


        <x-inputs.text id="salary" name="salary" label="Salary" type="number" placeholder="90000" :value="old('salary',$job->salary)" />

        <x-inputs.text-area id="requirements" name="requirements" label="Requirements" placeholder="Bachelor's Degree in Computer Science" :value="old('requirements',$job->description)" />


        <x-inputs.text-area id="benefits" name="benefits" label="Benefits" placeholder="Health insurance ,401k ,paid time of" :value="old('benefits',$job->benefits)" />


        <x-inputs.text id="tags" name="tags" label="Tags (comma-separated)" placeholder="development,coding,java,python" :value="old('tags',$job->tags)" />


        <x-inputs.select id="job_type" name="job_type" label="Job Type" :value=" old('job_type',$job->job_type)" :options="['Full-Time' => 'Full-Time', 'Part-Time' => 'Part-Time', 'Contract' => 'Contract', 'Temporary' => 'Temporary', 'Internship' => 'Internship', 'Volunteer' => 'Volunteer', 'On-Call' => 'On-Call']" />
            

            <x-inputs.select   id="remote"   name="remote" :value=" old('remote',$job->remote)"  label="Remote" :options="[0 => 'No', 1 => 'Yes']"   />


        <x-inputs.text id="address" name="address" :value="old('address',$job->address)" label="Address" placeholder="123 Mani st"  />

        <x-inputs.text id="city" name="city" :value="old('city',$job->city)" label="City" placeholder="Albany"  />

        <x-inputs.text id="state" name="state" :value="old('state',$job->state)" label="State" placeholder="NY"  />

        <x-inputs.text id="zipcode" name="zipcode" :value="old('zipcode',$job->zipcode)" label="Zipcode" placeholder="12201"  />
   

        <h2
            class="text-2xl font-bold mb-6 text-center text-gray-500"
        >
            Company Info
        </h2>

        <x-inputs.text id="company_name" name="company_name" label="Company Name" placeholder="Enter Company Name" :value="old('company_name',$job->company_name)"  />

        
        <x-inputs.text-area id="company_description" name="company_description" label="Company Description" placeholder="Enter company description" :value="old('company_description',$job->company_description)" />

        <x-inputs.text id="company_website" name="company_website" label="Website" type="url" placeholder="website" :value="old('company_website',$job->company_website)"  />

        <x-inputs.text id="contact_phone" name="contact_phone" label="Contact Phone" placeholder="Enter Phone" :value="old('contact_phone',$job->contact_phone)"  />


        <x-inputs.text id="contact_email" name="contact_email" type="email" label="Contact Email" placeholder="Email where you want to receive applications" :value="old('contact_email',$job->contact_email)" />

       <x-inputs.file id="company_logo" name="company_logo" label="Company Logo"/>



        <button
            type="submit"
            class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
        >
            Save
        </button>
    </form>
</div>
</x-layout>