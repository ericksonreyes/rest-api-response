<?php

namespace spec\EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\Error;
use EricksonReyes\RestApiResponse\Errors;
use EricksonReyes\RestApiResponse\ErrorSource;
use EricksonReyes\RestApiResponse\ErrorSourceType;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResourcesInterface;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponseInterface;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponseMediaTypeInterface;
use EricksonReyes\RestApiResponse\Link;
use EricksonReyes\RestApiResponse\Links;
use EricksonReyes\RestApiResponse\Meta;
use EricksonReyes\RestApiResponse\ResponseInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class JsonApiResponseSpec
 * @package spec\EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResponseSpec extends ObjectBehavior
{

    /**
     * @return void
     */
    public function it_can_be_initialized(): void
    {
        $this->shouldHaveType(JsonApiResponse::class);
        $this->shouldImplement(JsonApiResponseInterface::class);
        $this->shouldImplement(ResponseInterface::class);
    }

    /**
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourcesInterface $resources
     * @return void
     */
    public function it_has_resources(): void
    {
        $resource = new JsonApiResource(
            id: '1',
            type: 'user',
            attributes: [
                'first_name' => 'Erickson',
                'last_name' => 'Reyes'
            ]
        );

        $resources = new JsonApiResources();
        $resources->addResource($resource);

        $this->withResources($resources)->shouldBeNull();
        $this->resources()->shouldReturn($resources);
        $this->hasResources()->shouldBeBool();
        $this->hasNoResources()->shouldBeBool();
        $this->array()->shouldBeArray();
    }

    public function it_can_have_resources_with_relationships(): void
    {
        $resource = new JsonApiResource(
            id: '1',
            type: 'user',
            attributes: [
                'first_name' => 'Erickson',
                'last_name' => 'Reyes',
                'department_code' => 'dept-it'
            ]
        );

        $relationship = new JsonApiResource(
            id: 'dept-it',
            type: 'department',
            attributes: [
                'name' => 'IT Department'
            ]
        );
        $resource->addRelationship(
            relation: 'departments',
            resource: $relationship
        );

        $resources = new JsonApiResources();
        $resources->addResource($resource);
        $resources->setBaseUrl('http://localhost');

        $link = new Link(name: 'self', url:'/user/1');
        $links = new Links();
        $links->addLink($link);
        $resources->withLinks($links);

        $this->withResources($resources);
        $this->array()->shouldBeArray();
    }

    /**
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourcesInterface $resources
     * @return void
     */
    public function it_can_determine_if_it_has_resources_or_not(JsonApiResourcesInterface $resources): void
    {
        $resources->count()->shouldBeCalled()->willReturn(0);
        $this->withResources($resources);
        $this->hasResources()->shouldReturn(false);
        $this->hasNoResources()->shouldReturn(true);

        $resources->count()->shouldBeCalled()->willReturn(1);
        $this->withResources($resources);
        $this->hasResources()->shouldReturn(true);
        $this->hasNoResources()->shouldReturn(false);
    }

    /**
     * @return void
     */
    public function it_has_a_media_type(): void
    {
        $this->mediaType()->shouldReturn(JsonApiResponseMediaTypeInterface::RESPONSE_MEDIA_TYPE_JSON_API);
    }

    /**
     * @return void
     */
    public function it_has_specification_name(): void
    {
        $this->specificationName()->shouldReturn('jsonapi');
    }

    /**
     * @return void
     */
    public function it_has_version_number(): void
    {
        $this->specificationVersion()->shouldReturn('1.1');
    }

    /**
     * @return void
     */
    public function it_has_http_status_code(): void
    {
        $this->httpStatusCode()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_can_switch_http_status_code(): void
    {
        $this->setHttpStatusCode(403)->shouldBeNull();
        $this->httpStatusCode()->shouldReturn(403);
    }

    /**
     * @return void
     */
    public function it_has_http_response_description(): void
    {
        $this->describeHttpResponse('OK');
        $this->httpResponseDescription()->shouldReturn('OK');
    }

    /**
     * @param \EricksonReyes\RestApiResponse\MetaInterface $meta
     * @return void
     */
    public function it_has_meta_information(): void
    {
        $meta = new Meta();
        $meta->addMetaData(key: 'author', value: 'Erickson Reyes');

        $this->withMeta($meta)->shouldBeNull();
        $this->meta()->shouldReturn($meta);
        $this->array()->shouldBeArray();
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorsInterface $errors
     * @return void
     */
    public function it_can_have_error_messages(): void
    {
        $error = new Error(httpStatusCode: 500, title: 'Database down.');
        $error->withCode('DB_DOWN');
        $error->withDetail('Database connection is down.');
        $errorSource = new ErrorSource(
            type: ErrorSourceType::Parameter,
            source: 'q'
        );
        $error->fromSource($errorSource);

        $errors = new Errors();
        $errors->addError($error);
        $this->withErrors($errors)->shouldBeNull();

        $this->errors()->shouldReturn($errors);
        $this->httpStatusCode()->shouldReturn(500);
        $this->hasErrors()->shouldBeBool();
        $this->hasNoErrors()->shouldBeBool();
        $this->array()->shouldBeArray();
    }

    /**
     * @return void
     */
    public function it_has_a_string_representation(): void
    {
        $this->__toString()->shouldBeString();
    }

    /**
     * @return void
     */
    public function it_can_be_json_serialized(): void
    {
        $this->jsonSerialize()->shouldBeArray();
    }

    /**
     * @return void
     */
    public function it_can_have_pagination(): void
    {
        $resource = new JsonApiResource(
            id: '1',
            type: 'user',
            attributes: [
                'first_name' => 'Erickson',
                'last_name' => 'Reyes',
                'department_code' => 'dept-it'
            ]
        );

        $resources = new JsonApiResources();
        $resources->addResource($resource);
        $resources->setBaseUrl('http://localhost');

        $resources->withPagination(
            numberOfRecords: 100,
            recordsPerPage: 10,
            currentPageNumber: 2
        );

        $this->withResources($resources);
        $this->array()->shouldBeArray();
    }
}
