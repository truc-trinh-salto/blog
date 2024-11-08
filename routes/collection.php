<?php 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Number;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Contracts\Cache\LockTimeoutException;
use App\Models\User;
use App\Models\Book;
use App\Jobs\ProcessPodcast;
use Illuminate\Support\Collection;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Hash;

//Collection after with strict and closure
Route::get('after',function(){
    $collection = collect([1,2,3,4,5]);
    $after = $collection->after(function(int $item, int $key){
        return $item > 2;   
    }, strict: true);

    return $after;
});

//Collection all
Route::get('all',function(){
    $collection = collect([1,2,3,4,5]);
    $all = $collection->all();
    var_dump($all);

    return $all;
});

//Collection avg with closure
Route::get('avg',function(){
    $collection = collect([10, 20, 3, 4, 5]);
    $avg = $collection->avg(function(int $item){
        if($item > 4){
            return $item;
        }
    });
    
    return $avg;
});

//Collection before with closure and strict
Route::get('before',function(){
    $collection = collect([1,20,3,4,5,2]);
    $before = $collection->before(function(int $item, int $key){
        return $item > 5;
    }, strict: true);

    return $before;
});

//Collection chunk
Route::get('chunk',function(){
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 9 ,10]);
 
    $chunks = $collection->chunk(4);
    
    $chunks->all();

    return $chunks;
});

//Collection chunk while
Route::get('chunkWhile',function(){
    $collection = collect(str_split('AABBCCCD'));
 
    $chunks = $collection->chunkWhile(function (string $value, int $key, Collection $chunk) {
        echo $value.' '.$chunk->last().'</br>';
        return $value === $chunk->last();
    });
    
    $chunks->all();

    return $chunks;
});

//Collection collapse, flatten with deep = 1
Route::get('collapse',function(){
    $collection = collect([
        [[1,2,3], 2, 3],
        [4, [4,5,6], 6],
        [7, 8, 9],
    ]);
     
    $collapsed = $collection->collapse();
     
    $collapsed->all();

    return $collapsed;
});

//Collection collect, return new Instance of Collection with data currently 
Route::get('collect',function(){
    $lazyCollection = LazyCollection::make(function(){
        yield 1;
        yield 4;
        yield 6;

    });

    $collect = $lazyCollection->collect();

    var_dump($collect);

    return $collect;
});

//Collection combine, chosen collection is define key and the remaining is for value
Route::get('combine',function(){

    //Key
    $collection = collect(['phone','type']);

    //Value
    $newCollection = collect(['0934541496','Iphone']);

    //Combining key value
    $combine = $collection->combine($newCollection);

    return $combine;
});

//Collection concat, reindexes keys for appended items with concat
Route::get('concat',function(){
    $collection = collect(['name'=> 'Trung Truc']);

    //index of items are '0' : '21', '1' : '0934541496'
    $concat = $collection->concat(['age' => '21'])->concat(['0934541496']);

    return $concat[0];
});

//Collection contains, can check contains with value , 
Route::get('contains',function(){
    $collection = collect([['name' => 'Trung Truc','age' => 21, 'phone' =>'0934541496'],
                            ['name' => 'Nguyen Van A','age' => 22, 'phone' =>'012346789']]);

    $contain = $collection->contains('name','Trung Truc');

    return $contain;
});

//Collection count, count number of items in colleciton with deep = 1
Route::get('count',function(){
    $collection = collect([['5','sda',123,'384dsa'],[1,2,3,[4,5,7],5,6,7]]);
    
    $count = $collection->count();

    return $count;
});

//Collection countBy, count appearance of every item in single collection
Route::get('countBy',function(){
    $collection = collect([1,2,3,3,2,1,2,3,1,'s','1']);
    
    $count = $collection->countBy();



    $collection = collect(['alice@gmail.com.us', 'bob@yahoo.com.us', 'carlos@gmail.com.vn']);
 
    $counted = $collection->countBy(function (string $email) {
                //Split by @ and return index 1 of every str
        return substr(strrchr($email, "."), 1);
    });

    return $counted;
});

//Collection crossJoin
Route::get('crossJoin',function(){
    $collection = collect([1, 2]);
 
    $matrix = $collection->crossJoin(['X', 'Y', 'Z']);

    return $matrix;
    
});

//Collection diff, return new collection with not reindexes
Route::get('diff',function(){
    $collection = collect(['s','a','b',1,2,3]);

    $diff = $collection->diff(['s','a',3,2,4]);

    return $diff;
});

//Collection diffAssoc with using key value
Route::get('diffAssoc',function(){
    $collection = collect([
        'color' => 'orange',
        'type' => 'fruit',
        'remain' => 6,
        'used' => 5,
    ]);
     
    $diff = $collection->diffAssoc([
        'color' => 'yellow',
        'type' => 'fruit',
        'remain' => 6,
        'used' => 6,
    ]);
     
    return $diff;
});

//Collection doesn't contain, if doesn't contain return 1, else return ""
Route::get('doesntContain',function(){
    $collection = collect(['name' => 'Desk', 'price' => 100,1]);
 
    echo $collection->doesntContain(0);
    
    
    return $collection->doesntContain('Table');
});

//Collection dot to flatten a multi-dimen collection into a single collection with dot
Route::get('dot',function(){
    $collection = collect(['products'=>['table'=>['color'=>'yellow']]]);

    $dot = $collection->dot();

    return $dot;
});

//Collection duplicates, return the collection of items with duplicating without reindexes
Route::get('duplicates',function(){
    $collection = collect(['1',1,3,11,11,['a','b'],['a','b']]);

    $duplicates = $collection->duplicates();

    $employees = collect([
        ['email' => 'abigail@example.com', 'position' => 'Developer'],
        ['email' => 'james@example.com', 'position' => 'Designer'],
        ['email' => 'victoria@example.com', 'position' => 'Developer'],
    ]);
    

    return [$duplicates,$employees->duplicates('position')];
});

//Collection each
Route::get('each',function(){
    $collection = collect([1, 2, 3, 4]);
 
    $collection->each(function (int $item, int $key) {
        echo ($item + 1).'</br>';
        return $item + 1 ;
    });

    return $collection;
});

//Collection eachSpread, using for the nested array
Route::get('eachSpread',function(){
    $collection = collect([['John Doe', 35,'0934541496'], ['Jane Doe', 33,'093451496']]);
 
    $collection->eachSpread(function (string $name, int $age,string $phone) {
        echo $name.' '.$age.' '.$phone.'</br>';
    });
});

//Collection every, check condition of every items in collection, return true if pass all
Route::get('every',function(){
    $collection = collect([1,2,3,4,5,6,7,8,9,10]);

    $every = $collection->every(function(int $value, int $key){
        return $value > 0;
    },);

    return $every;
});

//Collection except, return the key without in except arrays of input parameters
Route::get('except',function(){
    $collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false,'phone'=>'0934541496','money'=>'10000']);
 
    $filtered = $collection->except(['price', 'discount','money']);

    return $filtered;
});

//Collection filter, return new Collection with item that pass the truth test
Route::get('filter',function(){
    $collection = collect([1, 2, 3, 4, 6 ,8]);
 
    $filtered = $collection->filter(function (int $value, int $key) {
        return $value % 2 == 0;
    });

    return $filtered;
});

//Collection first and firstWhere, return the first item with closure or not
Route::get('first',function(){
    $collection = collect([1, 2, 3, 4]);


    $first = $collection->first(function (int $value, int $key) {
        return $value > 2;
    });


    $collection = collect([
        ['name' => 'Trung Truc', 'age' => null,'phone' => '0934541496'],
        ['name' => 'Linda', 'age' => 14],
        ['name' => 'Diego', 'age' => 23],
        ['name' => 'Linda', 'age' => 84],
    ]);

    //Collection, if param is null, next item
    $firstWhere = $collection->firstWhere('age');

    return $firstWhere;

});


//Collection flatMap, return new Collection with current item with filtering
Route::get('flatMap',function(){
    $collection = collect([
        ['name' => 'Sally'],
        ['school' => 'Arkansas'],
        ['age' => 28]
    ]);
     
    $flatMap = $collection->flatMap(function (array $values) {
        return array_map('strtoupper', $values);
    });

    return $flatMap;
});


//Collection flatten, return new Collection with transform any multi-dimen into single hot  

Route::get('flatten',function(){
    $collection = collect([
        'name' => 'taylor',
        'languages' => [
            'php', 'javascript',['ruby','django',['c','c++']]
        ]
    ]);
     

    //Collection can passing the value of dept of collection flatten
    $flattened = $collection->flatten(2);

    return $flattened;
     
});


//Collection flip, swap key and value for key value pairs
Route::get('flip',function(){
    $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
 
    $flipped = $collection->flip();

    return $flipped;
});

//Collection forget, if using key value, forget with key
Route::get('forget',function(){
    $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
 
    // Forget a single key...
    $collection->forget('name');
    
    
    // Forget multiple keys...
    $collection->forget(['name', 'framework']);


    //Collection forget without reindexes of collection
    $collection = collect([1,2,3,4,5,6,7,8]);
 
    // Forget a single key...
    $collection->forget(3);
    
    
    // Forget multiple keys...
    $collection->forget([4, 6, 9]);

    return $collection;
});

//Collection forPage, return new collection with N-page and number item per page without reindexes
Route::get('forPage',function(){
    $collection = collect([1,2,3,4,5,6,7,8,9,10]);

    //Return collection of 3rd page and contains 4 item
    $chunk = $collection->forPage(3,4);

    return $chunk;
});

//Collection groupBy, groupBy collection with given key or multiple keys
Route::get('groupBy',function(){


    $collection = collect([
        ['account_id' => 'account-x10', 'product' => 'Chair'],
        ['account_id' => 'account-x10', 'product' => 'Bookcase'],
        ['account_id' => 'account-x11', 'product' => 'Desk'],
    ]);
     
    //Group by with single key with closure
    $grouped = $collection->groupBy(function (array $item, int $key) {
        return substr($item['account_id'], -3);
    });
     
    $grouped->all();


    //Group by with multiple keys
    $data = new Collection([
        10 => ['user' => 1, 'skill' => 1, 'roles' => ['Role_1', 'Role_3']],
        20 => ['user' => 2, 'skill' => 1, 'roles' => ['Role_1', 'Role_2']],
        30 => ['user' => 3, 'skill' => 2, 'roles' => ['Role_1']],
        40 => ['user' => 4, 'skill' => 2, 'roles' => ['Role_2']],
    ]);
     
    $result = $data->groupBy(['skill', function (array $item) {
        return $item['roles'];
    }], preserveKeys: true);


    return $result;
});

//Colletion has, return bool for checking given key exist in collection
Route::get('has',function(){
    $data = new Collection(
        ['user' => 1, 'skill' => 1, 'roles' => ['Role_1', 'Role_3']],
       
    );

    //True 1 
    echo $data->has('user');
    
    //True 1
    echo $data->has(['user','skill']);

    //False ""
    echo $data->has('age');

    //True 1
    echo $data->hasAny(['user','any']);
});

//Collection implode, imploding the values of collection with the given key
Route::get('implode',function(){
    $collection = collect([['user'=> 'Trung Truc','university'=>'TDT'],
                            ['user'=> 'Nguyen Van A','university'=>'UIT'],
                            ['user'=> 'Nguyen Van B','university'=>'UEH']]);

    $universities = $collection->implode('university',', ');

    $users = $collection->implode('user','-');

    return [$universities,$users];
});

//Collection intersect, removes any values from the original collection if it not present in the given collection 
//without reindexes from orginal collection
Route::get('intersect',function(){
    $orginal = collect(['Desk','PC','Chair','LAPTOP']);
    $collection = collect(['PC','LAPTOP','Keyboard','Mouse']);

    $intersected = $orginal->intersect($collection);

    return $intersected;
});


//Collection join, join values with String
Route::get('join',function(){
    $collection = collect(['Desk','PC','Chair','LAPTOP']);


    $join = $collection->join(', ',' and ');

    return $join;
});

//Collection keyBy
Route::get('keyBy',function(){
    $collection = collect([['user'=> 'Trung Truc','university'=>'TDT'],
                            ['user'=> 'Nguyen Van A','university'=>'UIT'],
                            ['user'=> 'Nguyen Van B','university'=>'UEH']]);

    $key = $collection->keyBy('user');

    // $users = $collection->implode('user','-');

    return $key['Trung Truc']['user'];
});

//Collection map
Route::get('map',function(){
    $collection = collect([1,2,3,4,5,6,7]);

    $map = $collection->map(function(int $item, int $key){
        return $item % 2 == 0 ? $item : 0;
    });

    return $map;
});


//Collection mapSpread
Route::get('mapSpread',function(){
    $collection = collect([1,2,3,4,[5,8],6,7]);

    $chunks = $collection->chunk(2);

    $mapSpread = $chunks->mapSpread(function($first , int $second){
        if(is_array($first)){
            $f = 0;
            foreach($first as $item){
               $f += $item; 
            }
        } else {
            $f = $first;
        }
        return $f + $second;
    });

    return $mapSpread;
});


//Collection mapToGroups
Route::get('mapToGroups',function(){
    $collection = collect([['user'=> 'Trung Truc','university'=>'TDT'],
                            ['user'=> 'Nguyen Van A','university'=>'TDT'],
                            ['user'=> 'Nguyen Van B','university'=>'UEH']]);
    
    $map = $collection->mapToGroups(function(array $item, string $key){
        return [$item['university'] => $item['user']];
    });

    return $map;
});

//Collection mapWithKeys
Route::get('mapWithKeys',function(){
    $collection = collect([['user'=> 'Trung Truc','university'=>'TDT'],
                            ['user'=> 'Nguyen Van A','university'=>'TDT'],
                            ['user'=> 'Nguyen Van B','university'=>'UEH']]);
    
    $map = $collection->mapWithKeys(function(array $item, string $key){
        return [$item['university'] => $item['user']];
    });

    return $map;
});


//Collection merge
Route::get('merge',function(){
    $original = collect(['name' => 'Trung Truc','age' => 21,'height' => 170]);

    $merge = $original->merge(['address' => 'District 7', 'age' => 22, 'Basketball']);

    return $merge;
});

//Collection merge
Route::get('mergeRecursive',function(){
    $original = collect(['name' => 'Trung Truc','age' => 21,'height' => 170]);

    $merge = $original->mergeRecursive(['address' => 'District 7', 'age' => 22, 'Basketball', 'name' => 'Bin']);

    return $merge;
});

//Collection multiply
Route::get('multiply',function(){
    $original = collect(['name' => 'Trung Truc','age' => 21,'height' => 170]);

    $merge = $original->mergeRecursive(['address' => 'District 7', 'age' => 22, 'sport'=>'Basketball', 'name' => 'Bin']);

    $multiply = $merge->multiply(3);

    return $multiply;
});


//Collection nth
Route::get('nth',function(){
    $collection = collect(['a', 'b', 'c', 'd', 'e', 'f']);

    $nth = $collection->nth(3,2);

    return $nth;
});

//Collection only
Route::get('only',function(){
    $original = collect(['name' => 'Trung Truc','age' => 21,'height' => 170]);

    $merge = $original->mergeRecursive(['address' => 'District 7', 'age' => 22, 'sport'=>'Basketball', 'name' => 'Bin']);

    $only = $merge->only([0,'name','height']);

    return $only;
});

//Collection partition
Route::get('partition',function(){
    $collection = collect([1,2,3,4,5,6,7,8]);

    [$even,$odd] = $collection->partition(function(int $i){
        return $i % 2 == 0;
    });

    return ['even' => $even , 'odd' => $odd];

});


//Collection pipeThrough
Route::get('pipeThrough',function(){
    $collection = collect([1,2,3,4,5,6,7,8]);

    $pipeThrough = $collection->pipeThrough([function(Collection $collection){
        return $collection->merge([9,10,11,12]);
    },
    function(Collection $collection){
        [$even,$odd] = $collection->partition(function(int $i){
            return $i % 2 == 0;
        });

        return ['even'=>$even,'odd'=>$odd];
    }]);

    return $pipeThrough;
});


//Collection pluck
Route::get('pluck',function(){
    $original = collect([
        ['product_id' => 'prod-100', 'name' => 'Desk'],
        ['product_id' => 'prod-200', 'name' => 'Chair'],
    ]);


    $pluck = $original->pluck('name','product_id');

    return $pluck;
});


//Collection reduce
Route::get('reduce',function(){
    $collection = collect()->range(0,10);

    $reduce = $collection->reduce(function(int $carry, int $value){
        return $carry + $value;
    }, 3);

    return $reduce;
});

//Collection reject
Route::get('reject',function(){
    $collection = collect()->range(0,10);

    $reject = $collection->reject(function(int $value, int $key){
        return $value < 2;
    });

    return $reject;
});

Route::get('replace',function(){
    $original = collect(['name' => 'Trung Truc','age' => 21,'height' => 170]);

    $merge = $original->merge(['address' => 'District 7', 'age' => 22, 'sport'=>'Basketball', 'name' => 'Bin']);

    $replace = $merge->replace(['name' =>'Trinh Truc','sport'=>'football']);

    return $replace;
});

//Route replaceRecursive

Route::get('replaceRecursive',function(){
    $original = collect(['name' => ['first'=>'Truc','last'=>'Trinh'],'age' => 21,'height' => 170]);

    $merge = $original->merge(['address' => 'District 7', 'age' => 22, 'sport'=>'Basketball']);

    $replace = $merge->replaceRecursive(['name' =>['first' => 'Nguyen'],'sport'=>'football']);

    return $replace;
});


//Route search
Route::get('search',function(){
    $collection = collect()->range(0,100);


    // $merge = $original->merge(['address' => 'District 7', 'age' => 22, 'sport'=>'Basketball']);

    $search = $collection->search(function(int $item, int $key){
        return $item > 50;
    });

    return $search;
});

//Route skipUntil
Route::get('skipUntil',function(){
    $collection = collect()->range(0,100);

    $skip = $collection->skipUntil(function(int $item){
        return $item > 50;
    });

    return $skip;
});

//Collection skipWhile
Route::get('skipWhile',function(){
    $collection = collect()->range(0,100);

    $skip = $collection->skipWhile(function(int $item){
        return $item > 50;
    });

    return $skip;
});

//Collection slice
Route::get('slice',function(){
    $collection = collect()->range(0,10);

    $slice = $collection->slice(5,3);

    return $slice;

});

//Collection sliding
Route::get('sliding',function(){
    $collection = collect()->range(0,5);

    $chunks = $collection->sliding(3,2);

    return $chunks;
});

//Collection sort
Route::get('sort',function(){
    $collection = collect([10,4,2,5,6,3,2,1,7,8,9]);

    $sort = $collection->sort();

    return $sort;
});

//Collection sortBy
Route::Get('sortBy',function(){
    $collection = collect([
        ['name' => 'Desk', 'price' => [1,2,3,4,5,6]],
        ['name' => 'Chair', 'price' => [1,2,3,4,5]],
        ['name' => 'Bookcase', 'price' => [1,2,3,4]],
        ['name' => 'BookcAse', 'price' => [1,2,3,7,9,9]],
    ]);

    // $sort = $collection->sortBy(function(array $arr, int $key){
    //     return count($arr['price']);
    // });


    $sorted = $collection->sortBy([
        fn (array $a, array $b) => $b['name'] <=> $a['name'],
        fn (array $a, array $b) => $b['price'] <=> $a['price'],
    ]);

    return $sorted;
});

//Collection splice, different with slice, remove items in original 
Route::get('splice',function(){
    $collection = collect()->range(0,20);

    $slice = $collection->splice(10);

    return ['original'=>$collection,'slice'=>$slice];
});

//Collection sum
Route::get('sum',function(){
    $collection = collect([
        ['name' => 'Desk', 'price' => [1,2,3,4,5,6]],
        ['name' => 'Chair', 'price' => [1,2,3,4,5]],
        ['name' => 'Bookcase', 'price' => [1,2,3,4]],
        ['name' => 'BookcAse', 'price' => [1,2,3,7,9,9]],
    ]);

    $sum = $collection->sum(function(array $arr){
        return count($arr['price']);
    });

    return $sum;
});

//Collection tap
Route::get('tap',function(){
    $tap = collect([2, 4, 3, 1, 5])
    ->sort()
    ->tap(function (Collection $collection) {
        
    });

    return $tap;
});

//Collection times
Route::get('times',function(){
    $collection = collect([1,2,3,4,5]);

    $times = $collection->times(2,function(int $number){
        return $number ** 2 ;
    });

    return $times;
});

//Collection transform
Route::get('transform',function(){
    $collection = collect()->range(0,10);

    $transform = $collection->transform(function(int $item, int $key){
        return $item ** 2;
    });

    return $transform;
});

//Collection undot
Route::get('undot',function(){
    $person = collect([
        'name.first_name' => 'Marie',
        'name.last_name' => 'Valentine',
        'address.line_1' => '2992 Eagle Drive',
        'address.line_2' => '',
        'address.suburb' => 'Detroit',
        'address.state' => 'MI',
        'address.postcode' => '48219'
    ]);

    $undot = $person->undot();

    return $undot;
});

//Collection unique
Route::get('unique',function(){
    $collection = collect([
        ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
        ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone'],
        ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
        ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
        ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
    ]);

    // $unique = $collection->unique('type');

    $unique = $collection->unique(function(array $arr){
        return $arr['brand'].$arr['type'];
    });

    return $unique;
});

//Collection when
Route::get('when',function(){
    $collection = collect([1,2,3,4,5]);

    $collection->when(false,function(Collection $collection, int $value){
        return $collection->push(6);
    },function(Collection $collection, int $value){
        return $collection->push(7);
    });

    return $collection;
});

//Collection where 
Route::get('where',function(){
    $collection = collect([
        ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone','price' => 50],
        ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone','price' => 100],
        ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch','price' => 150],
        ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone','price' => 200],
        ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch','price' => 300],
    ]);

    $filter = $collection->where('brand','Apple');

    $filter1 = $filter->whereBetween('price',[100,200]);

    $filter2 = $filter1->whereIn('type',['watch']);

    return $filter2;
});

//Collection zip
Route::get('zip',function(){
    $collection = collect(['PC','LAPTOP']);

    $zip = $collection->zip(['200','250']);

    return $zip;
});


//Lazy Collection
Route::get('lazy',function(){
    //Using cursor for returning Lazy Collection instance
    $books = Book::cursor()->filter(function(Book $book){
        return $book->stock > 0;
    });

    //filter method will excute when item is iterated
    foreach($books as $book){
        echo $book->title.'</br>';
    }

});

//Collection Lazy make method
Route::get('makeLazy',function(){
    $lazy = LazyCollection::make(function(){
        $handle = fopen('../example.txt','r');

        while(($line = fgets($handle)) !== false){
            yield $line;
        }
    });

    return $lazy;
});

//Collection tapEach in Lazy
Route::get('tapEachLazy',function(){
    $books = Book::cursor()->filter(function(Book $book){
        return $book->stock > 0;
    });

    $tapEach = $books->tapEach(function(Book $book){
        dump($book->title);
    });

    $array = $tapEach->take(3);

    return $array;
});

//Collection throttle in Lazy
Route::get('throttle',function(){
    $users = User::cursor()->throttle(1)->each(function(User $user){
        echo $user->email.'</br>';
    });
    
});

//Collection remember in Lazy
Route::get('remember',function(){
    $books = Book::cursor()->remember();

    $books->take(5);

    $books->take(20);

    return $books;
});



